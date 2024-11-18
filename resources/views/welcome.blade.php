



@extends('layouts.base')

@section('title', 'aquafit - le-site-des-sportifs')
@section('content')
<div class="welcome-container">
    <h1>Bienvenue sur Aquafit</h1>

    </div>
</div>

<style>
.welcome-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
    text-align: center;
}

.feature-cards {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
}

.button {
    display: inline-block;
    padding: 10px 20px;
    background: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    margin-top: 1rem;
}

.button:hover {
    background: #0056b3;
}
</style>
@endsection
