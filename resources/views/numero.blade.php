@extends('layouts.blank')

@section('title', 'NumÃ©ro')

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
        <h1 class="hero-title">Numéro</h1>
        <p class="hero-slogan">Veuillez saisir votre numéro</p>
      </div>
    </div>
  </div>
</section>

<main class="numero-content" style="position:relative; z-index:1;">
    <p class="instruction-text">Veuillez saisir votre numero {{ strtolower($net['name']) }}</p>

    <div class="selected-network-box" style="background-color: {{ $net['bg'] }}">
      <div class="network-icon-container" style="background-color: {{ $net['color'] }}">
        <img src="{{ $net['logo'] }}" alt="{{ $net['name'] }}" class="network-logo">
      </div>
      <span class="network-name">{{ $net['name'] }}</span>
    </div>

    <div class="input-section">
      <label class="input-label">numÃ©ro</label>
      <div class="phone-input-container">
        <span class="country-code">+225</span>
        <input type="tel" id="phoneInput" class="phone-input" placeholder="00 00 00 00 00" maxlength="14" />
      </div>
    </div>
  </main>

  <div class="continue-section">
    <button class="continue-button" onclick="(function(){ var v=document.getElementById('phoneInput').value.trim(); if(v){ window.location.href='/montant?network={{ $network }}&phone='+encodeURIComponent('+225 '+v); } })()">Continuer</button>
  </div>
@endsection
