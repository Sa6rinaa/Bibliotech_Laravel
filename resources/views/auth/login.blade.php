@extends('layouts.app')

@section('content')
<div class="container" style="max-width:480px;">
    <h2 class="mb-4">Connexion</h2>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="email" class="form-label">Adresse e-mail</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button class="btn btn-primary w-100" type="submit">Se connecter</button>
    </form>

    <p class="mt-3 text-center">
        <a href="{{ route('register') }}">Pas de compte ? Inscrivez‑vous</a>
    </p>
</div>
@endsection
