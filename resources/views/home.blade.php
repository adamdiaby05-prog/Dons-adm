@extends('layouts.mobile')

@section('title', 'Accueil')

@section('content')
<div class="screen home-screen">
    <div class="home-frame">
        <header class="home-header">
            <img src="/images/ad.png" alt="ADM" class="home-header__logo">
            <a href="/network" class="home-header__cta">Faire un don</a>
        </header>

        <div class="hero-card">
            <div class="hero-card__info">
                <span class="hero-card__tag">Campagne présidentielle 2025</span>
                <h1 class="hero-card__title">EN MARCHE POUR UNE CÔTE D'IVOIRE SOUVERAINE, JUSTE ET FORTE</h1>
                <p class="hero-card__subtitle">Souveraineté • Égalité • Justice</p>

                <div class="hero-card__actions">
                    <a href="/network" class="hero-action hero-action--primary">Je contribue maintenant</a>
                    <a href="/presentation" class="hero-action hero-action--outline">Découvrir la vision</a>
                </div>
            </div>

            <div class="hero-card__media">
                <div class="hero-card__portrait">
                    <img src="/images/pa.png" alt="Ahoua Don Mello">
                </div>
            </div>
        </div>

        <div class="vision-card">
            <h2 class="vision-card__title">Notre vision pour 2030</h2>
            <p class="vision-card__text">
                « Une Côte d'Ivoire prospère où chaque citoyen a accès à l'éducation, aux soins de santé et aux opportunités d'emploi.
                Ensemble, nous bâtirons un pays uni, fort de ses valeurs et résolument tourné vers l'avenir. »
            </p>
        </div>
    </div>
</div>
@endsection
