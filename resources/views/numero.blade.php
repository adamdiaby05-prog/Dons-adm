@extends('layouts.mobile')

@section('title', 'Numéro')

@php
    $networks = [
        'mtn' => ['name' => 'MTN MoMo', 'logo' => '/images/mtn.jpg', 'accent' => '#f59e0b', 'tint' => '#fff4dd'],
        'moov' => ['name' => 'MOOV Money', 'logo' => '/images/moov.jpg', 'accent' => '#2563eb', 'tint' => '#e5efff'],
        'orange' => ['name' => 'ORANGE Money', 'logo' => '/images/orange.jpg', 'accent' => '#f97316', 'tint' => '#ffe7da'],
        'wave' => ['name' => 'WACE CI', 'logo' => '/images/Wave.jpg', 'accent' => '#0ea5e9', 'tint' => '#e1f6ff'],
    ];
    $selected = $networks[$network] ?? $networks['wave'];
@endphp

@section('content')
<div class="screen numero-screen">
    <header class="top-bar">
        <a href="javascript:history.back()" class="top-bar__leading" aria-label="Retour">
            <span class="icon-arrow"></span>
        </a>
        <h1 class="top-bar__title">Numéro</h1>
    </header>

    <div class="screen__body screen__body--compact">
        <div class="content-wide">
            <div class="form-wrapper">
                <p class="screen-lead">Veuillez saisir votre numéro {{ strtolower($selected['name']) }}</p>

                <div class="pill numero-pill" style="--pill-accent: {{ $selected['accent'] }}; --pill-tint: {{ $selected['tint'] }};">
                    <span class="pill__icon">
                        <img src="{{ $selected['logo'] }}" alt="{{ $selected['name'] }}">
                    </span>
                    <span>{{ $selected['name'] }}</span>
                </div>

                <div class="input-stack">
                    <label for="phoneInput" class="field-label">numéro</label>
                    <div class="field-control">
                        <span class="field-prefix">+225</span>
                        <input
                            type="tel"
                            id="phoneInput"
                            class="field-input"
                            inputmode="numeric"
                            placeholder="00 00 00 00 00"
                            maxlength="14"
                            autocomplete="tel"
                            aria-label="Numéro de téléphone"
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="screen__footer">
        <button type="button" class="primary-button" onclick="submitNumero()">Continuer</button>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function submitNumero() {
        var input = document.getElementById('phoneInput');
        var value = input.value.replace(/\s+/g, '').trim();
        if (!value) {
            input.focus();
            return;
        }
        var formatted = value.match(/.{1,2}/g)?.join(' ') || value;
        var url = '/montant?network={{ $network }}&phone=' + encodeURIComponent('+225 ' + formatted);
        window.location.href = url;
    }
</script>
@endpush
