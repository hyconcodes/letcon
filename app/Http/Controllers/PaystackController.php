<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PaystackController extends Controller
{
    public function handleCallback(Request $request)
    {
        $reference = $request->query('reference');

        if (!$reference) {
            return redirect()->route('deposits')->with('error', 'No reference provided.');
        }

        $response = Http::withToken(env('PAYSTACK_SECRET_KEY'))
            ->get(env('PAYSTACK_PAYMENT_URL') . '/transaction/verify/' . $reference);

        $result = $response->json();

        if ($result['status'] && $result['data']['status'] === 'success') {
            // Payment was successful, update user or wallet
            // e.g., credit wallet, upgrade level, etc.
            return redirect()->route('deposits')->with('success', 'Payment successful!');
        }

        return redirect()->route('deposits')->with('error', 'Payment failed or could not be verified.');
    }
}
