@extends('layouts.mobile')

@section('title', 'Montant')

@php
    $networks = [
        'mtn' => ['name' => 'MTN MoMo', 'logo' => '/images/mtn.jpg', 'accent' => '#f59e0b', 'tint' => '#fff4dd'],
        'moov' => ['name' => 'MOOV Money', 'logo' => '/images/moov.jpg', 'accent' => '#2563eb', 'tint' => '#e5efff'],
        'orange' => ['name' => 'ORANGE Money', 'logo' => '/images/orange.jpg', 'accent' => '#f97316', 'tint' => '#ffe7da'],
        'wave' => ['name' => 'WACE CI', 'logo' => '/images/Wave.jpg', 'accent' => '#0ea5e9', 'tint' => '#e1f6ff'],
    ];
    $selected = $networks[$network] ?? $networks['wave'];
@endphp

@section('content')
<div class="screen montant-screen">
    <header class="top-bar">
        <a href="javascript:history.back()" class="top-bar__leading" aria-label="Retour">
            <span class="icon-arrow"></span>
        </a>
        <h1 class="top-bar__title">Montant</h1>
    </header>

    <div class="screen__body screen__body--compact">
        <div class="content-wide">
            <div class="form-wrapper">
                <p class="screen-lead">Quel montant souhaitez-vous donner&nbsp;?</p>

                <div class="donation-summary" style="--pill-accent: {{ $selected['accent'] }}; --pill-tint: {{ $selected['tint'] }};">
                    <span class="donation-summary__icon">
                        <img src="{{ $selected['logo'] }}" alt="{{ $selected['name'] }}">
                    </span>
                    <div class="donation-summary__details">
                        <span class="donation-summary__network">{{ $selected['name'] }}</span>
                        <span class="donation-summary__phone">{{ $phone }}</span>
                    </div>
                </div>

                <div class="amount-field">
                    <label for="amountInput" class="field-label">montant</label>
                    <div class="amount-control">
                        <span class="amount-prefix">F CFA</span>
                        <input
                            type="text"
                            id="amountInput"
                            class="amount-input"
                            inputmode="numeric"
                            placeholder="000 000"
                            autocomplete="off"
                            aria-label="Montant du don"
                            oninput="formatAmount(this)"
                        >
                    </div>
                    <p class="screen-helper">Saisissez un montant supérieur à 1&nbsp;000&nbsp;F&nbsp;CFA.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="screen__footer">
        <button type="button" class="primary-button" onclick="submitAmount(this)">Valider</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function formatAmount(input) {
        var raw = input.value.replace(/\D/g, '');
        if (!raw) {
            input.value = '';
            return;
        }
        input.value = raw.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    }

    function submitAmount(button) {
        var input = document.getElementById('amountInput');
        var normalized = input.value.replace(/\s+/g, '');
        if (!normalized) {
            input.focus();
            return;
        }
        var amount = parseInt(normalized, 10);
        if (isNaN(amount) || amount <= 0) {
            input.focus();
            return;
        }

        var originalText = button.textContent;
        button.disabled = true;
        button.textContent = 'Création du paiement...';

        var params = new URLSearchParams({
            amount: amount,
            network: '{{ $network }}',
            phone: '{{ $phone }}'
        });

        fetch('/payments?' + params.toString(), {
            method: 'GET',
            headers: { 'Accept': 'application/json' }
        })
        .then(function (response) {
            if (!response.ok) {
                throw new Error('HTTP ' + response.status);
            }
            return response.json();
        })
        .then(function (data) {
            if (data && data.success && data.payment_url) {
                window.location.href = data.payment_url;
            } else {
                alert(data.message || 'Une erreur est survenue lors de la création du paiement.');
                button.disabled = false;
                button.textContent = originalText;
            }
        })
        .catch(function (error) {
            console.error(error);
            alert('Impossible de contacter le serveur. Veuillez réessayer.');
            button.disabled = false;
            button.textContent = originalText;
        });
    }
</script>
@endpush
