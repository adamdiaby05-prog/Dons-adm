@extends('layouts.blank')

@section('title', 'RÃ©seau')

@section('content')
<section class="hero-section">
  <div class="container">
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title">Réseau</h1>
        <p class="hero-slogan">Choisissez votre opérateur</p>
      </div>
    </div>
  </div>
</section>

<main class="network-content" style="position:relative; z-index:1;">
    <p class="instruction-text">Choisissez votre reseau</p>

    <div class="network-options">
      <a href="/numero?network=mtn" class="network-option mtn-momo">
        <div class="option-icon mtn-icon">
          <img src="/images/mtn.jpg" alt="MTN" class="network-logo" />
        </div>
        <span class="option-text">MTN MoMo</span>
      </a>

      <a href="/numero?network=moov" class="network-option moov-money">
        <div class="option-icon moov-icon">
          <img src="/images/moov.jpg" alt="MOOV" class="network-logo" />
        </div>
        <span class="option-text">MOOV Money</span>
      </a>

      <a href="/numero?network=orange" class="network-option orange-money">
        <div class="option-icon orange-icon">
          <img src="/images/orange.jpg" alt="ORANGE" class="network-logo" />
        </div>
        <span class="option-text">ORANGE Money</span>
      </a>

      <a href="/numero?network=wave" class="network-option wace-ci">
        <div class="option-icon wace-icon">
          <img src="/images/Wave.jpg" alt="WAVE" class="network-logo" />
        </div>
        <span class="option-text">WAVE CI</span>
      </a>
    </div>
  </main>
@endsection
