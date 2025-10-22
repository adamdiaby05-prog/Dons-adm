@extends('layouts.mobile')

@section('title', 'Paiement')

@php
    $statusLabel = match ($status) {
        'approved' => 'Paiement validé',
        'canceled' => 'Paiement annulé',
        default => 'Statut en attente',
    };

    $statusTone = match ($status) {
        'approved' => 'success',
        'canceled' => 'danger',
        default => 'info',
    };
@endphp

@section('content')
<div class="screen status-screen">
    <header class="top-bar">
        <a href="/" class="top-bar__leading" aria-label="Accueil">
            <span class="icon-arrow"></span>
        </a>
        <h1 class="top-bar__title">Paiement</h1>
    </header>

    <div class="screen__body screen__body--compact">
        <div class="content-wide">
            <div class="status-card status-card--{{ $statusTone }}">
                <div class="status-card__icon" aria-hidden="true">
                    @if($status === 'approved')
                        ✓
                    @elseif($status === 'canceled')
                        ✕
                    @else
                        ⧗
                    @endif
                </div>
                <h2 class="status-card__title">{{ $statusLabel }}</h2>
                <p class="status-card__subtitle">
                    @if($status === 'approved')
                        Merci pour votre engagement.
                    @elseif($status === 'canceled')
                        Aucun débit n'a été effectué. Vous pouvez réessayer plus tard.
                    @else
                        Nous attendons la confirmation de l'opérateur. Rafraîchissez cette page dans quelques instants.
                    @endif
                </p>
            </div>

            <dl class="status-details">
                @if($transaction_id)
                    <div class="status-details__item">
                        <dt>ID transaction</dt>
                        <dd>{{ $transaction_id }}</dd>
                    </div>
                @endif

                @if(request('amount'))
                    <div class="status-details__item">
                        <dt>Montant</dt>
                        <dd>{{ request('amount') }} XOF</dd>
                    </div>
                @endif

                @if(request('network'))
                    <div class="status-details__item">
                        <dt>Réseau</dt>
                        <dd>{{ ucfirst(request('network')) }}</dd>
                    </div>
                @endif

                @if(request('phone'))
                    <div class="status-details__item">
                        <dt>Téléphone</dt>
                        <dd>{{ request('phone') }}</dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>

    <div class="screen__footer">
        <a href="/" class="primary-button">Retour à l'accueil</a>
    </div>
</div>
@endsection
