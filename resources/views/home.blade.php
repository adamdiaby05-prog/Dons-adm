@extends('layouts.app')

@section('title', 'Accueil')

@section('content')
<main>
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <div class="hero-text">
                    <h1 class="hero-title">EN MARCHE POUR UNE CÔTE<br> D'IVOIRE SOUVERAINE, JUSTE,<br> ET FORTE</h1>
                    <p class="hero-slogan">SOUVERAINETÉ - ÉGALITÉ - JUSTICE</p>
                </div>
                
                <div class="candidate-card">
                    <div class="candidate-photo">
                        <img src="/images/pa.png" alt="Ahoua Don Mello" class="candidate-image">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="vision-section">
        <div class="container">
            <div class="vision-box">
                <h2 class="vision-title">Notre Vision</h2>
                <p class="vision-text">
                    Ensemble, construisons un avenir prospère et durable pour notre nation. 
                    Votre soutien est essentiel pour réaliser nos ambitions communes et 
                    transformer notre vision en réalité concrète pour tous.
                </p>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <div class="button-group">
                <a href="/network" class="cta-button">
                    <span>💝</span>
                    <span>Faire un Don</span>
                </a>
                <a href="/presentation" class="candidate-button">
                    <span>👤</span>
                    <span>En savoir plus</span>
                </a>
            </div>
        </div>
    </section>
</main>
@endsection
