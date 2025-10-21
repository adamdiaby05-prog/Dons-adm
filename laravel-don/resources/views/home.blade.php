@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<div class="home-page">
  <section class="hero-section">
    <div class="hero-content">
      <div class="hero-text">
        <h1 class="hero-title">EN MARCHE POUR UNE CÃ”TE<br> D'IVOIRE SOUVERAINE, JUSTE,<br> ET FORTE</h1>
        <p class="hero-slogan">SOUVERAINETÃ‰ - Ã‰GALITÃ‰ - JUSTICE</p>
      </div>
      <div class="hero-image-container">
        <div class="hero-shapes">
          <div class="candidate-photo">
            <img src="/images/pa.png" alt="Ahoua Don Mello" class="candidate-image">
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="vision-section">
    <div class="vision-box">
      <h2 class="vision-title">Notre vision pour 2030</h2>
      <p class="vision-text">
        "Une CÃ´te d'Ivoire prospÃ¨re oÃ¹ chaque citoyen a accÃ¨s Ã  l'Ã©ducation, 
        aux soins de santÃ© et aux opportunitÃ©s d'emploi. Ensemble, nous 
        bÃ¢tirons un pays uni dans sa diversitÃ©, fort de ses valeurs et 
        tournÃ© vers l'avenir."
      </p>
    </div>
  </section>

  <section class="cta-section">
    <div style="text-align:center;">
      <a href="/network" class="btn btn-primary cta-button">Faire un don</a>
    </div>
  </section>
</div>
@endsection
