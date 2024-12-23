<!DOCTYPE html>
<html lang="fr">


<head>
    <title> @yield('title', 'aquafit') </title>
    <link href="/css/style.css" rel="stylesheet">
    <link href="/css/progstyle.css" rel="stylesheet">
    <link href="/css/exostyle.css" rel="stylesheet">
    <link href="/css/login_register.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
</head>

<body>
    @include('layouts.header')
    <main>
        @yield('content')
    </main>
    @include('layouts.footer')
</body>


</html>
