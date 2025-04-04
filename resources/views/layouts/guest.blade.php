<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'AquaFit') }} - @yield('title', 'Authentification')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    
    <!-- Styles -->
    <link href="{{ asset('css/aquafit.css') }}" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="auth-page">
        <div class="auth-container">
            <div class="auth-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('images/logo.svg') }}" alt="AquaFit Logo">
                </a>
            </div>
            
            <div class="auth-content">
                {{ $slot }}
            </div>
        </div>
        
        <div class="auth-footer">
            <p>&copy; {{ date('Y') }} AquaFit | Tous droits réservés</p>
        </div>
    </div>

    <style>
    :root {
        /* Couleurs */
        --white: #ffffff;
        --black: #000000;
        --blue-primary: #0077B6;
        --blue-secondary: #00B4D8;
        --blue-dark: #03045E;
        --blue-light: #90E0EF;
        --blue-pale: #CAF0F8;
        --blue-very-pale: #EFF8FB;
        --dark-gray: #343A40;
        --light-gray: #F8F9FA;
        
        /* Espacement */
        --spacing-xxs: 0.25rem;
        --spacing-xs: 0.5rem;
        --spacing-sm: 0.75rem;
        --spacing-md: 1rem;
        --spacing-lg: 1.5rem;
        --spacing-xl: 2rem;
        --spacing-xxl: 3rem;
        
        /* Typographie */
        --font-family-primary: 'Poppins', sans-serif;
        --font-family-secondary: 'Montserrat', sans-serif;
        --font-size-xs: 0.75rem;
        --font-size-sm: 0.875rem;
        --font-size-base: 1rem;
        --font-size-lg: 1.25rem;
        --font-size-xl: 1.5rem;
        --font-size-xxl: 2rem;
        --font-weight-light: 300;
        --font-weight-normal: 400;
        --font-weight-medium: 500;
        --font-weight-semibold: 600;
        --font-weight-bold: 700;
        
        /* Bordures */
        --border-radius-sm: 4px;
        --border-radius-md: 8px;
        --border-radius-lg: 12px;
        --border-width-thin: 1px;
        --border-width: 2px;
        
        /* Ombres */
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        --shadow-md: 0 4px 6px rgba(0,0,0,0.1);
        --shadow-lg: 0 10px 15px rgba(0,0,0,0.1);
        
        /* Transitions */
        --transition-normal: 0.3s;
        --transition-slow: 0.5s;
        --transition-ease: ease-in-out;
    }
    
    body {
        font-family: var(--font-family-primary);
        margin: 0;
        padding: 0;
        color: var(--dark-gray);
        background: linear-gradient(135deg, var(--blue-pale), var(--blue-very-pale));
        min-height: 100vh;
    }
    
    .auth-page {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: var(--spacing-md);
    }
    
    .auth-container {
        width: 100%;
        max-width: 450px;
        background-color: var(--white);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
        overflow: hidden;
        margin-bottom: var(--spacing-xl);
    }
    
    .auth-logo {
        background: linear-gradient(135deg, var(--blue-primary), var(--blue-secondary));
        padding: var(--spacing-xl) 0;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .auth-logo img {
        height: 60px;
    }
    
    .auth-content {
        padding: var(--spacing-xl);
    }
    
    .auth-footer {
        color: var(--blue-dark);
        text-align: center;
        font-size: var(--font-size-sm);
    }
    
    .form-group {
        margin-bottom: var(--spacing-lg);
    }
    
    .form-label {
        display: block;
        margin-bottom: var(--spacing-xs);
        font-weight: var(--font-weight-medium);
        color: var(--blue-dark);
    }
    
    .form-control {
        width: 100%;
        padding: var(--spacing-md);
        border: var(--border-width-thin) solid var(--blue-pale);
        border-radius: var(--border-radius-sm);
        font-family: inherit;
        font-size: var(--font-size-base);
        transition: border-color var(--transition-normal) var(--transition-ease);
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--blue-primary);
        box-shadow: 0 0 0 3px rgba(0, 119, 182, 0.25);
    }
    
    .form-error {
        color: #dc3545;
        font-size: var(--font-size-sm);
        margin-top: var(--spacing-xs);
    }
    
    .form-check {
        display: flex;
        align-items: center;
        margin-bottom: var(--spacing-md);
    }
    
    .form-check-input {
        margin-right: var(--spacing-xs);
    }
    
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--spacing-md);
        margin-top: var(--spacing-xl);
    }
    
    .form-links {
        margin-top: var(--spacing-md);
        text-align: center;
    }
    
    .form-links a {
        color: var(--blue-primary);
        text-decoration: none;
        transition: color var(--transition-normal) var(--transition-ease);
    }
    
    .form-links a:hover {
        color: var(--blue-dark);
        text-decoration: underline;
    }
    
    .btn {
        display: inline-block;
        padding: var(--spacing-sm) var(--spacing-lg);
        border-radius: var(--border-radius-sm);
        font-weight: var(--font-weight-medium);
        cursor: pointer;
        text-align: center;
        transition: all var(--transition-normal) var(--transition-ease);
        text-decoration: none;
        border: none;
    }
    
    .btn-primary {
        background-color: var(--blue-primary);
        color: var(--white);
        box-shadow: var(--shadow-sm);
    }
    
    .btn-primary:hover, .btn-primary:focus {
        background-color: var(--blue-dark);
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }
    
    .btn-outline {
        background-color: transparent;
        border: 1px solid var(--blue-primary);
        color: var(--blue-primary);
    }
    
    .btn-outline:hover, .btn-outline:focus {
        background-color: var(--blue-very-pale);
    }
    
    .auth-title {
        color: var(--blue-dark);
        font-family: var(--font-family-secondary);
        font-weight: var(--font-weight-bold);
        margin-top: 0;
        margin-bottom: var(--spacing-lg);
        text-align: center;
    }
    
    .auth-subtitle {
        color: var(--dark-gray);
        font-size: var(--font-size-base);
        margin-bottom: var(--spacing-xl);
        text-align: center;
    }
    
    .alert {
        padding: var(--spacing-md);
        border-radius: var(--border-radius-md);
        margin-bottom: var(--spacing-lg);
    }
    
    .alert-success {
        background-color: #d4edda;
        border-color: #c3e6cb;
        color: #155724;
    }
    
    .alert-danger {
        background-color: #f8d7da;
        border-color: #f5c6cb;
        color: #721c24;
    }
    
    /* Responsive Styles */
    @media (max-width: 480px) {
        .auth-container {
            max-width: 100%;
        }
        
        .auth-logo img {
            height: 50px;
        }
        
        .auth-content {
            padding: var(--spacing-lg);
        }
        
        .form-actions {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
    </style>
</body>
</html>
