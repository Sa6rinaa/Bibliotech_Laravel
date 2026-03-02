@extends('layouts.app', ['title' => 'Accueil'])

@section('content')
<div class="container">
    {{-- Hero Section --}}
    <div class="row mb-5">
        <div class="col-12">
            <div class="bg-primary text-white rounded-3 p-5 text-center">
                <h1 class="display-4 mb-3">
                    <i class="fas fa-book-open"></i>
                    Bienvenue sur BiblioTech
                </h1>
                <p class="lead mb-4">
                    Votre système de gestion de bibliothèque moderne, développé avec Laravel
                </p>
                <a href="{{ route('livres.index') }}" class="btn btn-light btn-lg">
                    <i class="fas fa-search"></i> Explorer le Catalogue
                </a>
            </div>
        </div>
    </div>

    {{-- Statistiques --}}
    <div class="row mb-5">
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 border-primary">
                <div class="card-body">
                    <i class="fas fa-book fa-2x text-primary mb-2"></i>
                    <h3 class="text-primary">{{ $stats['totalLivres'] }}</h3>
                    <p class="card-text">Livres au total</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 border-success">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h3 class="text-success">{{ $stats['livresDisponibles'] }}</h3>
                    <p class="card-text">Disponibles</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 border-warning">
                <div class="card-body">
                    <i class="fas fa-hand-holding fa-2x text-warning mb-2"></i>
                    <h3 class="text-warning">{{ $stats['totalEmprunts'] }}</h3>
                    <p class="card-text">Emprunts actifs</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center h-100 border-info">
                <div class="card-body">
                    <i class="fas fa-users fa-2x text-info mb-2"></i>
                    <h3 class="text-info">{{ $stats['totalUtilisateurs'] }}</h3>
                    <p class="card-text">Utilisateurs</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Livres mis en avant --}}
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="fas fa-star text-warning"></i>
                Livres mis en avant
            </h2>
        </div>
        
            @foreach($livresEnVedette as $livre)
        <div class="col-md-4 mb-4">
                <x-livre-card :livre="$livre" />
        </div>
        @endforeach
    </div>

    {{-- Appel à l'action --}}
    <div class="row mt-5">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body text-center py-5">
                    <h3>Découvrir BiblioTech</h3>
                    <p class="lead text-muted">
                        Explorez notre catalogue complet ou apprenez-en plus sur notre système
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <a href="{{ route('livres.index') }}" class="btn btn-primary">
                            <i class="fas fa-book"></i> Voir tous les livres
                        </a>
                            <a href="{{ route('livres.search') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-search"></i> Recherche avancée
                        </a>
                        <a href="{{ route('about') }}" class="btn btn-outline-info">
                            <i class="fas fa-info-circle"></i> À propos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection