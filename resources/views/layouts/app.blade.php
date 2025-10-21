<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dons')</title>
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="/css/network.css">
    <link rel="stylesheet" href="/css/numero.css">
    <link rel="stylesheet" href="/css/montant.css">
    <link rel="stylesheet" href="/css/presentation.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-content">
                <a href="/" class="logo">
                    <div class="logo-container">
                        <img src="/images/ad.png" alt="ADM Logo" class="logo-image" />
                    </div>
                </a>
                
                <div class="header-icon">
                    <img src="/images/shield.png" alt="Shield" class="shield-icon" />
                </div>
            </div>
        </div>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>
