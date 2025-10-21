@extends('layouts.blank')

@section('title', 'Paiement')

@section('content')
<section class="hero-section">
    <div class="container">
        <div class="hero-text">
            @if($status === 'approved')
                <h1 class="hero-title">✅ Paiement Réussi</h1>
                <p class="hero-slogan">Merci pour votre don !</p>
            @elseif($status === 'canceled')
                <h1 class="hero-title">❌ Paiement Annulé</h1>
                <p class="hero-slogan">Votre paiement a été annulé</p>
            @else
                <h1 class="hero-title">⏳ Statut du Paiement</h1>
                <p class="hero-slogan">Vérification en cours...</p>
            @endif
        </div>
        
        <div class="payment-details">
            @if($transaction_id)
                <div class="detail-item">
                    <span class="label">ID Transaction:</span>
                    <span class="value">{{ $transaction_id }}</span>
                </div>
            @endif
            
            @if(request('amount'))
                <div class="detail-item">
                    <span class="label">Montant:</span>
                    <span class="value">{{ request('amount') }} XOF</span>
                </div>
            @endif
            
            @if(request('network'))
                <div class="detail-item">
                    <span class="label">Réseau:</span>
                    <span class="value">{{ ucfirst(request('network')) }}</span>
                </div>
            @endif
            
            @if(request('phone'))
                <div class="detail-item">
                    <span class="label">Téléphone:</span>
                    <span class="value">{{ request('phone') }}</span>
                </div>
            @endif
            
            @if($status)
                <div class="detail-item">
                    <span class="label">Statut:</span>
                    <span class="value status-{{ $status }}">{{ ucfirst($status) }}</span>
                </div>
            @endif
        </div>
        
        <div class="action-buttons">
            <a href="/" class="cta-button">
                <span>🏠</span>
                <span>Retour à l'accueil</span>
            </a>
            
            @if($status === 'approved')
                <a href="/presentation" class="candidate-button">
                    <span>👤</span>
                    <span>En savoir plus</span>
                </a>
            @endif
        </div>
    </div>
</section>

<style>
.payment-details {
    background: rgba(255, 255, 255, 0.1);
    backdrop-filter: blur(20px);
    border-radius: 20px;
    padding: 2rem;
    margin: 2rem 0;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.detail-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.detail-item:last-child {
    border-bottom: none;
}

.label {
    font-weight: 600;
    color: rgba(255, 255, 255, 0.8);
}

.value {
    font-weight: 700;
    color: #fff;
}

.status-approved {
    color: #10b981 !important;
}

.status-canceled {
    color: #ef4444 !important;
}

.action-buttons {
    display: flex;
    gap: 1rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 2rem;
}

.cta-button, .candidate-button {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    background: linear-gradient(135deg, #dc2626, #991b1b);
    color: white;
    text-decoration: none;
    border-radius: 15px;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(220, 38, 38, 0.3);
}

.candidate-button {
    background: linear-gradient(135deg, #1e40af, #1e3a8a);
    box-shadow: 0 10px 30px rgba(30, 64, 175, 0.3);
}

.cta-button:hover, .candidate-button:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(220, 38, 38, 0.4);
}

.candidate-button:hover {
    box-shadow: 0 15px 40px rgba(30, 64, 175, 0.4);
}

@media (max-width: 768px) {
    .action-buttons {
        flex-direction: column;
        align-items: center;
    }
    
    .cta-button, .candidate-button {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
}
</style>
@endsection
