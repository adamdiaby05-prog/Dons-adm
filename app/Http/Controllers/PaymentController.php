<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'network' => 'required|string',
            'phone' => 'required|string',
        ]);

        // Map network to payment method
        $methodMap = [
            'orange' => 'orange_money',
            'mtn' => 'mtn_mobile_money',
            'moov' => 'moov_money',
            'wave' => 'orange_money', // fallback supported
        ];

        $paymentMethod = $methodMap[$request->network] ?? $request->network;

        $payment = Payment::create([
            'amount' => $request->amount,
            'currency' => 'XOF',
            'payment_method' => $paymentMethod,
            'phone_number' => $request->phone,
            'network' => $request->network,
            'status' => 'pending',
            'notes' => 'Paiement créé via interface web'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Paiement enregistré avec succès',
            'payment_id' => $payment->id,
            'amount' => $payment->amount,
            'currency' => $payment->currency
        ]);
    }
}
