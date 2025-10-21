<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dons - ADM')</title>
    <link rel="icon" href="/favicon.ico">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif; overflow-x: hidden; background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); }
        .container { max-width: 1400px; margin: 0 auto; padding: 0 2rem; }
        .particles { position: fixed; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none; z-index: 0; }
        .particle { position: absolute; width: 4px; height: 4px; background: rgba(255, 255, 255, 0.5); border-radius: 50%; animation: float-particle 15s infinite; }
        @keyframes float-particle { 0%,100%{ transform: translateY(0) translateX(0); opacity:0 } 10%{ opacity:1 } 90%{ opacity:1 } 100%{ transform: translateY(-100vh) translateX(100px); opacity:0 } }
    </style>
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="/css/network.css">
    <link rel="stylesheet" href="/css/numero.css">
    <link rel="stylesheet" href="/css/montant.css">
    <link rel="stylesheet" href="/css/presentation.css">
</head>
<body>
    <div class="particles" id="particles"></div>
    <main>
        @yield('content')
    </main>
    <script>
        const particlesContainer = document.getElementById('particles');
        const particleCount = 50;
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.className = 'particle';
            particle.style.left = Math.random() * 100 + '%';
            particle.style.animationDelay = Math.random() * 15 + 's';
            particle.style.animationDuration = (Math.random() * 10 + 10) + 's';
            particlesContainer.appendChild(particle);
        }
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.hero-content, .candidate-card');
            parallaxElements.forEach(el => { const speed = 0.5; el.style.transform = `translateY(${scrolled * speed}px)`; });
        });
    </script>
</body>
</html>
