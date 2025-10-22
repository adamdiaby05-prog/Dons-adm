<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Campagne ADM')</title>
    <link rel="icon" href="/favicon.ico">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/mobile.css">
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="/css/network.css">
    <link rel="stylesheet" href="/css/numero.css">
    <link rel="stylesheet" href="/css/montant.css">
    <link rel="stylesheet" href="/css/presentation.css">
    @stack('styles')
</head>
<body class="app-body">
    <div class="app-shell">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>
