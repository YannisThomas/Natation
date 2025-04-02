@extends('layouts.base')
@section('title', 'aquafit - le-site-des-sportifs')
@section('content')
<div class="login-container">
    <x-guest-layout>
        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <!-- Email Address -->
            <div class="form-group">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full input-field" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 error-message" />
            </div>

            <!-- Password -->
            <div class="form-group mt-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full input-field" type="password" name="password" required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 error-message" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="checkbox" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                <a class="forgot-password" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif

                <x-primary-button class="btn-submit ms-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>
    </x-guest-layout>
</div>
@endsection