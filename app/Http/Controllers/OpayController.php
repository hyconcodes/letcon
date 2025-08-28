<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Payment;
use App\Models\Wallet;
use Exception;

class OpayController extends Controller
{
    private $secretKey;
    private $merchantId;
    private $url;

    public function __construct()
    {
        $this->merchantId = env('OPAY_MERCHANT_ID'); // Add this to your .env
        $this->secretKey = env('OPAY_SECRET_KEY');
        $this->url = 'https://testapi.opaycheckout.com/api/v1/international/cashier/status';
    }

    public function handleCallback(Request $request)
    {
        dd("Received from Opay...");
        try {
            // Log the callback payload
            Log::info('Opay Callback Received', $request->all());

            $reference = $request->input('reference');

            if (!$reference) {
                Log::error('Reference missing in callback request');
                return response()->json(['error' => 'Reference missing'], 400);
            }

            // Prepare data for OPay verify API (following their documentation)
            $data = [
                'country' => 'NG',
                'reference' => $reference
            ];

            // Convert to JSON string for HMAC authentication
            $jsonData = json_encode($data, JSON_UNESCAPED_SLASHES);

            // Generate HMAC authentication
            $auth = $this->generateAuth($jsonData);

            // Call OPay verify API with proper headers
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $auth,
                'MerchantId' => $this->merchantId
            ])->post($this->url, $data);

            if ($response->failed()) {
                Log::error('Opay Verify Failed', [
                    'reference' => $reference,
                    'response' => $response->json(),
                    'status' => $response->status()
                ]);
                return response()->json(['error' => 'Verification failed'], 500);
            }

            $responseData = $response->json();

            // Check response code first (OPay uses "00000" for success)
            if (!isset($responseData['code']) || $responseData['code'] !== '00000') {
                Log::error('Opay API returned error', [
                    'reference' => $reference,
                    'response' => $responseData
                ]);
                return redirect()->route('deposits')->with('error', 'Payment verification failed.');
            }

            // Check if transaction is successful (status should be "SUCCESS", not "INITIAL")
            if (isset($responseData['data']['status']) && $responseData['data']['status'] === 'SUCCESS') {
                try {
                    // Get amount from response (OPay returns amount in minor units)
                    $amount = $responseData['data']['amount']['total'] / 100; // Convert from kobo to naira

                    // Update payment record
                    $payment = Payment::create([
                        'user_id' => Auth::id(),
                        'amount' => $amount,
                        'status' => 'paid',
                        'reference' => $reference,
                        'payment_method' => 'opay',
                        'payment_method_code' => 'opay',
                        // 'order_no' => $responseData['data']['orderNo'] ?? null // Store OPay order number
                    ]);

                    if (!$payment) {
                        throw new Exception('Failed to create payment record');
                    }

                    // Create or update wallet
                    $wallet = Wallet::firstOrCreate(
                        ['user_id' => Auth::id()],
                        ['balance' => 0]
                    );

                    if (!$wallet) {
                        throw new Exception('Failed to create/update wallet');
                    }

                    $wallet->increment('balance', $amount);

                    Log::info('Payment processed successfully', [
                        'reference' => $reference,
                        // 'order_no' => $responseData['data']['orderNo'] ?? null,
                        'payment_id' => $payment->id,
                        'wallet_id' => $wallet->id,
                        'amount' => $amount
                    ]);

                    return redirect()->route('wallets')->with('success', 'Payment successful!');
                } catch (Exception $e) {
                    Log::error('Failed to process successful payment', [
                        'error' => $e->getMessage(),
                        'reference' => $reference,
                        'trace' => $e->getTraceAsString()
                    ]);
                    return redirect()->route('deposits')->with('error', 'Payment processed but failed to update records.');
                }
            }

            try {
                // Create failed payment record for non-successful transactions
                $amount = isset($responseData['data']['amount']['total'])
                    ? $responseData['data']['amount']['total'] / 100
                    : 0;

                $failedPayment = Payment::create([
                    'user_id' => Auth::id(),
                    'amount' => $amount,
                    'status' => 'failed',
                    'reference' => $reference,
                    'payment_method' => 'opay',
                    'payment_method_code' => 'opay',
                    // 'order_no' => $responseData['data']['orderNo'] ?? null
                ]);

                if (!$failedPayment) {
                    throw new Exception('Failed to create failed payment record');
                }

                Log::warning('Opay Payment Not Successful', [
                    'reference' => $reference,
                    'status' => $responseData['data']['status'] ?? 'unknown',
                    'data' => $responseData,
                    'payment_id' => $failedPayment->id
                ]);
            } catch (Exception $e) {
                Log::error('Failed to save failed payment record', [
                    'error' => $e->getMessage(),
                    'reference' => $reference,
                    'trace' => $e->getTraceAsString()
                ]);
            }

            // Return appropriate message based on status
            $status = $responseData['data']['status'] ?? 'unknown';
            $message = $this->getStatusMessage($status);

            return redirect()->route('deposits')->with('error', $message);
        } catch (Exception $e) {
            Log::error('Unexpected error in payment callback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->route('deposits')->with('error', 'An unexpected error occurred.');
        }
    }

    /**
     * Generate HMAC authentication as per OPay documentation
     */
    private function generateAuth($data)
    {
        return hash_hmac('sha512', $data, $this->secretKey);
    }

    /**
     * Get user-friendly message based on payment status
     */
    private function getStatusMessage($status)
    {
        switch ($status) {
            case 'INITIAL':
                return 'Payment is still being processed. Please wait.';
            case 'PENDING':
                return 'Payment is pending. Please check back later.';
            case 'FAILED':
                return 'Payment failed. Please try again.';
            case 'CANCELED':
                return 'Payment was canceled.';
            default:
                return 'Payment could not be verified. Please contact support.';
        }
    }
}
