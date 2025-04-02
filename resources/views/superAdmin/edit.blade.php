@extends('layouts.auth.auth')

@section('title', 'Modifier un utilisateur')

@section('content')
<link href="{{ asset('css/superAdmin_edit.css') }}" rel="stylesheet">

<div class="container">
    <h2>Modifier un utilisateur</h2>

    <form method="POST" action="{{ route('superadmin.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" id="firstname" class="form-control" value="{{ old('firstname', $user->firstname) }}" required>
        </div>

        <div class="form-group">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname" class="form-control" value="{{ old('lastname', $user->lastname) }}" required>
        </div>

        <div class="form-group">
            <label for="email">Adresse Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="form-group">
            <label for="role_id">Rôle</label>
            <select name="role_id" id="role_id" class="form-control" required>
                @foreach ($roles as $role)
                    <option value="{{ $role->id }}" {{ $user->role_id === $role->id ? 'selected' : '' }}>
                        {{ $role->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>
</div>
@endsection
