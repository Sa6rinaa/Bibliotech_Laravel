@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Espace administrateur</h1>
    <p>Seuls les comptes dont le rôle est <code>admin</code> peuvent voir cette page.</p>
    <p>Fonctionnalités à implémenter :</p>
    <ul>
        <li>Gestion des utilisateurs</li>
        <li>Modération des contenus</li>
        <li>etc.</li>
    </ul>

    <a href="{{ route('dashboard') }}" class="btn btn-secondary">Retour au tableau de bord</a>
</div>
@endsection
