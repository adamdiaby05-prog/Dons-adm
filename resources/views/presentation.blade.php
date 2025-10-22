@extends('layouts.mobile')

@section('title', 'Présentation')

@section('content')
<div class="screen presentation-screen">
    <header class="top-bar">
        <a href="javascript:history.back()" class="top-bar__leading" aria-label="Retour">
            <span class="icon-arrow"></span>
        </a>
        <h1 class="top-bar__title">Présentation</h1>
    </header>

    <div class="screen__body screen__body--compact presentation-body">
        <div class="content-wide">
            <h2 class="presentation-heading">Présentation du candidat</h2>

            <div class="presentation-layout">
                <div class="presentation-hero">
                    <img src="/images/pa.jpg" alt="Ahoua Don Mello" class="presentation-hero__image">
                </div>

                <div class="presentation-layout__content">
                    <p class="presentation-text">
                        <strong>Ahoua Don Mello</strong>, né le 23 juin 1958 à Bongouanou, est un enseignant-chercheur et homme politique ivoirien.
                        Il dirige le Bureau national d'études techniques et de développement de 2000 à 2011. Ahoua Don Mello se déclare candidat à l'élection présidentielle de 2025.
                    </p>
                </div>
            </div>

            <div class="presentation-divider"></div>

            <section class="priorities">
                <header class="priorities__header">
                    <span class="priorities__icon">
                        <img src="/images/c.png" alt="Cible">
                    </span>
                    <h3 class="priorities__title">Nos priorités pour la Côte d'Ivoire</h3>
                </header>

                <div class="priorities__grid">
                    <figure class="priorities__card">
                        <img src="/images/a.png" alt="Éducation" class="priorities__image">
                    </figure>
                    <figure class="priorities__card">
                        <img src="/images/b.png" alt="Santé" class="priorities__image">
                    </figure>
                </div>
            </section>
        </div>
    </div>

    <div class="screen__footer">
        <a href="/network" class="primary-button presentation-button">Faire un don</a>
    </div>
</div>
@endsection
