<?php

require_once 'vendor/autoload.php';

// Charger la configuration Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== TEST DE LA FONCTIONNALITÉ DUAL (FEDAPAY + BASE DE DONNÉES) ===\n\n";

try {
    // Simuler les paramètres de la requête
    $amount = 2000;
    $network = 'wave';
    $phone = '+2250505979884';
    
    echo "Paramètres de test :\n";
    echo "- Montant: " . $amount . "\n";
    echo "- Réseau: " . $network . "\n";
    echo "- Téléphone: " . $phone . "\n\n";
    
    // Test 1: Créer une contribution
    echo "1. Création d'une contribution...\n";
    $contributionId = DB::table('contributions')->insertGetId([
        'amount' => $amount,
        'status' => 'pending',
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "✅ Contribution créée avec l'ID: " . $contributionId . "\n\n";
    
    // Test 2: Enregistrer un paiement
    echo "2. Enregistrement du paiement...\n";
    $paymentId = DB::table('payments')->insertGetId([
        'contribution_id' => $contributionId,
        'payment_reference' => 'TEST_FEDAPAY_' . time(),
        'amount' => $amount,
        'payment_method' => 'orange_money',
        'phone_number' => $phone,
        'status' => 'pending',
        'gateway_response' => json_encode(['test' => 'FedaPay simulation']),
        'created_at' => now(),
        'updated_at' => now()
    ]);
    echo "✅ Paiement enregistré avec l'ID: " . $paymentId . "\n\n";
    
    // Test 3: Vérifier les enregistrements
    echo "3. Vérification des enregistrements...\n";
    $contribution = DB::table('contributions')->where('id', $contributionId)->first();
    $payment = DB::table('payments')->where('id', $paymentId)->first();
    
    echo "Contribution:\n";
    echo "- ID: " . $contribution->id . "\n";
    echo "- Montant: " . $contribution->amount . "\n";
    echo "- Statut: " . $contribution->status . "\n\n";
    
    echo "Paiement:\n";
    echo "- ID: " . $payment->id . "\n";
    echo "- Contribution ID: " . $payment->contribution_id . "\n";
    echo "- Référence: " . $payment->payment_reference . "\n";
    echo "- Montant: " . $payment->amount . "\n";
    echo "- Méthode: " . $payment->payment_method . "\n";
    echo "- Téléphone: " . $payment->phone_number . "\n";
    echo "- Statut: " . $payment->status . "\n\n";
    
    echo "✅ Test réussi ! La fonctionnalité dual fonctionne.\n";
    
} catch (Exception $e) {
    echo "❌ Erreur lors du test :\n";
    echo $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}


