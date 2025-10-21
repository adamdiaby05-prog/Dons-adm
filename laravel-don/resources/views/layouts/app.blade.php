<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dons')</title>
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="/css/home.css">
    <link rel="stylesheet" href="/css/network.css">\n</head>
<body>
    <header style="padding:1rem;text-align:center;">
        <a href="/" style="text-decoration:none;color:inherit;"><h1 style="margin:0;">Dons</h1></a>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>

