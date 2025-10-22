@extends('layouts.app')

@section('title', 'RÃ©seau')

@section('content')
<div class="network-page">
  <header class="network-header">
    <div class="header-content">
      <a href="/" class="back-button">â†</a>
      <h1 class="page-title">RÃ©seau</h1>
    </div>
    <div class="header-line"></div>
  </header>

  <main class="network-content">
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
</div>
@endsection
