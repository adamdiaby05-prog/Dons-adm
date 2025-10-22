<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\PagesController;

Route::get('/', [PagesController::class, 'home']);
Route::get('/network', [PagesController::class, 'network']);
Route::get('/numero', [PagesController::class, 'numero']);
Route::get('/montant', [PagesController::class, 'montant']);
Route::get('/presentation', [PagesController::class, 'presentation']);

// Payment success page
Route::get('/payment-success', function() {
    $transactionId = request('id');
    $status = request('status');
    
    return view('payment-success', [
        'transaction_id' => $transactionId,
        'status' => $status
    ]);
});

// Test route
Route::get('/test', function() {
    return response()->json(['message' => 'Test route works']);
});

Route::get('/test-payment', function() {
    $amount = request('amount', 1000);
    $network = request('network', 'wave');
    $phone = request('phone', '+225 0505979884');
    
    // Normalize phone
    $digits = preg_replace('/[^0-9]/', '', $phone);
    if (str_starts_with($digits, '225')) {
        $digits = substr($digits, 3);
    }
    if ($digits !== '' && !str_starts_with($digits, '0')) {
        $digits = '0' . $digits;
    }
    if (strlen($digits) > 10) {
        $digits = substr($digits, 0, 10);
    }
    
    return response()->json([
        'success' => true,
        'message' => 'Test payment endpoint works',
        'data' => [
            'amount' => $amount,
            'network' => $network,
            'original_phone' => $phone,
            'normalized_phone' => $digits,
            'phone_valid' => preg_match('/^0[0-9]{9}$/', $digits)
        ]
    ]);
});

// Payment routes - FedaPay integration + Database storage
Route::get('/payments', function() {
    $amount = request('amount', 1000);
    $network = request('network', 'wave');
    $phone = request('phone', '+225 0505979884');
    
    // Debug logging
    \Log::info('Payment request received', [
        'amount' => $amount,
        'network' => $network,
        'phone' => $phone
    ]);
    
    // Normalize CI phone for FedaPay: send local number (0XXXXXXXXX) with country 'ci'
    // Remove all non-digit characters
    $digits = preg_replace('/[^0-9]/', '', $phone);
    
    // Remove 225 prefix if present
    if (str_starts_with($digits, '225')) {
        $digits = substr($digits, 3);
    }
    
    // Ensure it starts with 0
    if ($digits !== '' && !str_starts_with($digits, '0')) {
        $digits = '0' . $digits;
    }
    
    // Keep only 10 digits
    if (strlen($digits) > 10) {
        $digits = substr($digits, 0, 10);
    }
    
    $localPhone = $digits;
    
    // Debug logging after normalization
    \Log::info('Phone normalization result', [
        'original_phone' => $phone,
        'normalized_phone' => $localPhone,
        'digits_length' => strlen($localPhone)
    ]);

    // Validate CI local format 0XXXXXXXXX (10 digits)
    if (!preg_match('/^0[0-9]{9}$/', $localPhone)) {
        return response()->json([
            'success' => false,
            'message' => 'Numéro invalide. Utilisez un numéro CI à 10 chiffres commençant par 0.',
            'phone_received' => request('phone'),
            'phone_normalized' => $localPhone
        ], 400);
    }
    
    // FedaPay API configuration
    $apiKey = config('fedapay.secret_key', 'your_secret_key_here');
    $baseUrl = config('fedapay.base_url', 'https://api.fedapay.com/v1');
    
    // Force Orange Money for ALL networks (CORS-free solution)
    $paymentMode = 'orange_money'; // Universal Orange Money mode
    
    // Create transaction with explicit mode
    $transactionData = [
        'description' => 'Don pour la campagne ADM',
        'amount' => intval($amount),
        'currency' => ['iso' => 'XOF'],
        'callback_url' => 'http://127.0.0.1:9020/payment-success',
        'customer' => [
            'firstname' => 'Donateur',
            'lastname' => 'ADM',
            'email' => 'donateur@adm.ci',
            'phone_number' => [
                'number' => $localPhone,
                'country' => 'ci'
            ]
        ],
        'merchant_reference' => 'DON_ADM_' . time(),
        'mode' => $paymentMode
    ];
    
    // Create transaction using cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $baseUrl . '/transactions');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($transactionData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    
    $transactionResponse = curl_exec($ch);
    $transactionHttpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($transactionHttpCode !== 200) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur création transaction FedaPay: ' . $transactionResponse,
            'http_code' => $transactionHttpCode
        ], 500);
    }
    
    $transaction = json_decode($transactionResponse, true);
    $transactionId = $transaction['v1/transaction']['id'];
    $paymentUrl = $transaction['v1/transaction']['payment_url'];
    
    // ENREGISTRER LE PAIEMENT DANS LA BASE DE DONNÉES (table payments)
    try {
        $payment = Payment::create([
            'contribution_id' => 1, // ID de contribution par défaut
            'payment_reference' => 'FEDAPAY_' . $transactionId,
            'amount' => $amount,
            'payment_method' => $paymentMode,
            'phone_number' => $localPhone,
            'status' => 'pending',
            'gateway_response' => json_encode($transaction)
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Erreur enregistrement base de données: ' . $e->getMessage()
        ], 500);
    }
    
    return response()->json([
        'success' => true,
        'message' => 'Transaction FedaPay créée et paiement enregistré en base',
        'transaction_id' => $transactionId,
        'payment_id' => $payment->id,
        'amount' => $amount,
        'currency' => 'XOF',
        'network' => $network,
        'phone' => $localPhone,
        'payment_url' => $paymentUrl,
        'status' => 'pending',
        'environment' => 'live'
    ]);
});
