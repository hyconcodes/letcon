<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class PaystackController extends Controller
{
    public function handleCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('deposits')->with('error', 'No reference provided.');
        }

        // Check if user has already made one-time payment
        $existingPayment = Payment::where('user_id', Auth::id())
            ->where('status', 'paid')
            ->first();

        if ($existingPayment) {
            return redirect()->route('deposits')->with('error', 'You have already made the one-time payment.');
        }

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->get(env('PAYSTACK_PAYMENT_URL') . '/transaction/verify/' . $reference);

        $result = $response->json();

        if ($result['status'] && $result['data']['status'] === 'success') {
            // Update payment record
            $payment = Payment::create([
                'user_id' => Auth::id(),
                'amount' => $result['data']['amount'] / 100, // Convert from kobo to naira
                'status' => 'paid',
                'reference' => $reference,
                'payment_method' => 'paystack',
                'payment_method_code' => $result['data']['channel']
            ]);

            // Create or update wallet
            $wallet = Wallet::firstOrCreate(
                ['user_id' => Auth::id()],
                ['balance' => 0]
            );

            $wallet->increment('balance', $result['data']['amount'] / 100);

            return redirect()->route('wallets')->with('success', 'Payment successful!');
        }

        // Create failed payment record
        Payment::create([
            'user_id' => Auth::id(),
            'amount' => $result['data']['amount'] / 100,
            'status' => 'failed',
            'reference' => $reference,
            'payment_method' => 'paystack',
            'payment_method_code' => $result['data']['channel'] ?? null
        ]);

        return redirect()->route('deposits')->with('error', 'Payment failed or could not be verified.');
    }
}
