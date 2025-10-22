<?php

require_once 'vendor/autoload.php';

// Charger la configuration Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\DB;

echo "=== STRUCTURE DE LA TABLE CONTRIBUTIONS ===\n\n";

try {
    // Récupérer la structure de la table contributions
    $columns = DB::select("SELECT column_name, data_type, is_nullable, column_default 
                          FROM information_schema.columns 
                          WHERE table_name = 'contributions' 
                          ORDER BY ordinal_position");
    
    echo "Colonnes de la table 'contributions' :\n";
    echo "----------------------------------------\n";
    
    foreach ($columns as $column) {
        echo "Colonne: " . $column->column_name . "\n";
        echo "Type: " . $column->data_type . "\n";
        echo "Nullable: " . $column->is_nullable . "\n";
        echo "Default: " . ($column->column_default ?? 'NULL') . "\n";
        echo "----------------------------------------\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur lors de la récupération de la structure :\n";
    echo $e->getMessage() . "\n";
}

echo "\n=== EXEMPLE DE CONTRIBUTION EXISTANTE ===\n";

try {
    $contribution = DB::table('contributions')->first();
    if ($contribution) {
        echo "Exemple de contribution existante :\n";
        foreach ($contribution as $key => $value) {
            echo $key . ": " . ($value ?? 'NULL') . "\n";
        }
    } else {
        echo "Aucune contribution trouvée.\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur lors de la récupération de l'exemple :\n";
    echo $e->getMessage() . "\n";
}


