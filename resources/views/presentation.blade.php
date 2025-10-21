@extends('layouts.app')

@section('title', 'PrÃ©sentation du candidat')

@section('content')
<div class="presentation-page">
  <header class="presentation-header">
    <h1 class="page-title">PrÃ©sentation du candidat</h1>
    <div class="header-line"></div>
  </header>

  <main class="presentation-content">
    <div class="candidate-image-section">
      <img src="/images/pa.jpg" alt="Ahoua Don Mello" class="candidate-main-image" />
    </div>

    <div class="candidate-description">
      <p class="description-text">
        <strong>Ahoua Don Mello</strong>, nÃ© le 23 juin 1958 Ã  Bongouanou, est un enseignant-chercheur et homme politique ivoirien. Il dirige le Bureau national d'Ã©tudes techniques et de dÃ©veloppement de 2000 Ã  2011. Ahoua Don Mello se dÃ©clare candidat Ã  l'Ã©lection prÃ©sidentielle de 2025.
      </p>
    </div>

    <div class="priorities-section">
      <div class="priorities-header">
        <div class="priority-icon">
          <img src="/images/c.png" alt="PrioritÃ©s" class="priority-icon-image" />
        </div>
        <h3 class="priorities-title">Nos prioritÃ©s pour la CÃ´te d'Ivoire</h3>
      </div>

      <div class="priorities-grid">
        <div class="priority-card education-card">
          <img src="/images/a.png" alt="Ã‰ducation" class="priority-image" />
        </div>

        <div class="priority-card health-card">
          <img src="/images/b.png" alt="SantÃ©" class="priority-image" />
        </div>
      </div>

      <div class="donation-section">
        <a href="/network" class="donation-button">Faire un don</a>
      </div>
    </div>
  </main>
</div>
@endsection
