<?php

use Illuminate\Support\Facades\Route;
use App\Models\Payment;

// Home route
Route::get('/', function () {
    return view('home');
});

// Campaign routes
Route::get('/network', function () {
    return view('network');
});

Route::get('/numero', function () {
    $network = request('network');
    return view('numero', compact('network'));
});

Route::get('/montant', function () {
    $network = request('network');
    $phone = request('phone');
    return view('montant', compact('network', 'phone'));
});

Route::get('/presentation', function () {
    $network = request('network');
    $phone = request('phone');
    $amount = request('amount');
    return view('presentation', compact('network', 'phone', 'amount'));
});

// Payment success route
Route::get('/payment-success', function () {
    $status = request('status', 'completed');
    return view('payment-success', compact('status'));
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
    try {
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
        
        // For now, return a test response instead of calling FedaPay
        return response()->json([
            'success' => true,
            'message' => 'Test payment endpoint works - FedaPay integration ready',
            'data' => [
                'amount' => $amount,
                'network' => $network,
                'original_phone' => $phone,
                'normalized_phone' => $localPhone,
                'phone_valid' => true,
                'fedapay_ready' => true
            ]
        ]);
        
    } catch (\Exception $e) {
        \Log::error('Payment endpoint error', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);
        
        return response()->json([
            'success' => false,
            'message' => 'Erreur serveur: ' . $e->getMessage()
        ], 500);
    }
});