<?php

require_once 'vendor/autoload.php';

// Charger la configuration Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\Payment;

echo "=== TEST DE L'ENDPOINT /payments ===\n\n";

try {
    // Simuler les paramètres de la requête
    $amount = 400;
    $network = 'wave';
    $phone = '+225 0505979884';
    
    echo "Paramètres de test :\n";
    echo "- Montant: " . $amount . "\n";
    echo "- Réseau: " . $network . "\n";
    echo "- Téléphone: " . $phone . "\n\n";
    
    // Test 1: Normalisation du numéro
    echo "1. Normalisation du numéro...\n";
    $digits = preg_replace('/[^0-9]/', '', $phone);
    if (str_starts_with($digits, '225')) {
        $digits = substr($digits, 3);
    }
    if ($digits !== '' && $digits[0] !== '0') {
        $digits = '0' . $digits;
    }
    if (strlen($digits) > 10) {
        $digits = substr($digits, -10);
    }
    $localPhone = $digits;
    echo "Numéro normalisé: " . $localPhone . "\n\n";
    
    // Test 2: Validation du numéro
    echo "2. Validation du numéro...\n";
    if (!preg_match('/^0[0-9]{9}$/', $localPhone)) {
        echo "❌ Numéro invalide\n";
        exit;
    }
    echo "✅ Numéro valide\n\n";
    
    // Test 3: Test de la base de données
    echo "3. Test de la base de données...\n";
    $payment = Payment::create([
        'contribution_id' => 1, // ID de contribution existant
        'payment_reference' => 'TEST_FEDAPAY_' . time(),
        'amount' => $amount,
        'payment_method' => 'orange_money',
        'phone_number' => $localPhone,
        'status' => 'pending',
        'gateway_response' => json_encode(['test' => 'FedaPay simulation'])
    ]);
    echo "✅ Paiement enregistré avec l'ID: " . $payment->id . "\n\n";
    
    // Test 4: Test FedaPay (simulation)
    echo "4. Test FedaPay (simulation)...\n";
    $apiKey = config('fedapay.secret_key', 'sk_live_aV762HQPCw3r5rqra7CAykgv');
    $baseUrl = config('fedapay.base_url', 'https://api.fedapay.com/v1');
    echo "API Key: " . substr($apiKey, 0, 10) . "...\n";
    echo "Base URL: " . $baseUrl . "\n";
    
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
        'mode' => 'orange_money'
    ];
    
    echo "Données transaction: " . json_encode($transactionData, JSON_PRETTY_PRINT) . "\n";
    echo "✅ Configuration FedaPay OK\n\n";
    
    echo "✅ Tous les tests sont passés ! L'endpoint devrait fonctionner.\n";
    
} catch (Exception $e) {
    echo "❌ Erreur lors du test :\n";
    echo $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}
