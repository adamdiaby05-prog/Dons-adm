@extends('layouts.mobile')

@section('title', 'Réseau')

@section('content')
<div class="screen network-screen">
    <header class="top-bar">
        <a href="javascript:history.back()" class="top-bar__leading" aria-label="Retour">
            <span class="icon-arrow"></span>
        </a>
        <h1 class="top-bar__title">Réseau</h1>
    </header>

    <div class="screen__body screen__body--compact">
        <div class="content-wide">
            <p class="screen-lead">Choisissez votre réseau</p>

            <div class="list-stack network-stack">
                <a href="/numero?network=mtn" class="network-card network-card--mtn" aria-label="Choisir MTN MoMo">
                    <span class="network-card__icon">
                        <img src="/images/mtn.jpg" alt="Logo MTN" />
                    </span>
                    <span class="network-card__label">MTN MoMo</span>
                </a>

                <a href="/numero?network=moov" class="network-card network-card--moov" aria-label="Choisir MOOV Money">
                    <span class="network-card__icon">
                        <img src="/images/moov.jpg" alt="Logo MOOV" />
                    </span>
                    <span class="network-card__label">MOOV Money</span>
                </a>

                <a href="/numero?network=orange" class="network-card network-card--orange" aria-label="Choisir ORANGE Money">
                    <span class="network-card__icon">
                        <img src="/images/orange.jpg" alt="Logo Orange" />
                    </span>
                    <span class="network-card__label">ORANGE Money</span>
                </a>

                <a href="/numero?network=wave" class="network-card network-card--wave" aria-label="Choisir WAVE CI">
                    <span class="network-card__icon">
                        <img src="/images/Wave.jpg" alt="Logo Wave" />
                    </span>
                    <span class="network-card__label">WACE CI</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
