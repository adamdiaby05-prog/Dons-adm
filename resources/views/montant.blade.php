@extends('layouts.blank')

@section('title', 'Montant')

@section('content')
@php
  $config = [
    'mtn' => ['name' => 'MTN MoMo', 'logo' => '/images/mtn.jpg', 'color' => '#fbbf24', 'bg' => '#fef3c7'],
    'moov' => ['name' => 'MOOV Money', 'logo' => '/images/moov.jpg', 'color' => '#1e40af', 'bg' => '#dbeafe'],
    'orange' => ['name' => 'ORANGE Money', 'logo' => '/images/orange.jpg', 'color' => '#ea580c', 'bg' => '#fed7aa'],
    'wave' => ['name' => 'WAVE CI', 'logo' => '/images/Wave.jpg', 'color' => '#0891b2', 'bg' => '#e0f2fe'],
  ];
  $net = $config[$network] ?? $config['wave'];
@endphp

<section class="hero-section">
  <div class="container">
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title">Montant</h1>
        <p class="hero-slogan">Entrez le montant souhaité</p>
      </div>
    </div>
  </div>
</section>

<main class="montant-content" style="position:relative; z-index:1;">
    <p class="instruction-text">Veuillez entrer le montant souhaité</p>

    <div class="selected-network-box" style="background-color: {{ $net['bg'] }}">
      <div class="network-icon-container" style="background-color: {{ $net['color'] }}">
        <img src="{{ $net['logo'] }}" alt="{{ $net['name'] }}" class="network-logo">
      </div>
      <span class="phone-number">{{ $phone }}</span>
    </div>

    <div class="amount-input-section">
      <div class="amount-input-container">
        <span class="currency-prefix" id="placeholder">0.00</span>
        <input type="text" class="amount-input" id="amountInput" oninput="handleAmountInput(this)" />
        <span class="currency-suffix">F</span>
      </div>
    </div>
  </main>

  <div class="validate-section">
    <button class="validate-button" onclick="validatePayment()">Valider</button>
  </div>

  <script>
    function handleAmountInput(input) {
      const value = input.value;
      if (!/^\d*\.?\d*$/.test(value)) {
        input.value = value.slice(0, -1);
      }
      document.getElementById('placeholder').style.display = input.value ? 'none' : 'block';
    }

    function validatePayment() {
      const amount = document.getElementById('amountInput').value.trim();
      const network = '{{ $network }}';
      const phone = '{{ $phone }}';
      
      if (!amount || parseFloat(amount) <= 0) {
        alert('Veuillez entrer un montant valide');
        return;
      }

      const button = document.querySelector('.validate-button');
      const originalText = button.textContent;
      button.textContent = 'Création du paiement...';
      button.disabled = true;

      const url = `/payments?amount=${encodeURIComponent(parseFloat(amount))}&network=${encodeURIComponent(network)}&phone=${encodeURIComponent(phone)}`;
      
      fetch(url, {
        method: 'GET',
        headers: {
          'Accept': 'application/json'
        }
      })
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
      })
      .then(data => {
        console.log('FedaPay Response:', data);
        if (data.success && data.payment_url) {
          window.location.href = data.payment_url;
        } else {
          alert('Erreur lors de la création du paiement: ' + (data.message || 'Erreur inconnue'));
          button.textContent = originalText;
          button.disabled = false;
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert('Erreur de connexion au serveur: ' + error.message);
        button.textContent = originalText;
        button.disabled = false;
      });
    }
  </script>
@endsection
