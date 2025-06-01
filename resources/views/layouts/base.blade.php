<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Aquafit - Gestion d\'entraînements de natation')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/aquafit.css') }}" rel="stylesheet">
    <link href="{{ asset('css/progstyle.css') }}" rel="stylesheet">
    <link href="{{ asset('css/exostyle.css') }}" rel="stylesheet">
    
    <!-- Scripts -->
    @vite('resources/css/app.css')
</head>
<body>
    @include('layouts.header')
    
    <main>
        <div class="container">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif
            
            @yield('content')
        </div>
    </main>
    
    @include('layouts.footer')
</body>
</html>