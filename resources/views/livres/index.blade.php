@extends('layouts.app', [
    'title' => 'Catalogue des livres',
    'breadcrumbs' => [
        ['label' => 'Catalogue', 'url' => null]
    ]
])

@section('content')
<div class="container">
    {{-- En-tête avec statistiques --}}
    <div class="row mb-4">
                            <div class="col-12 text-center mb-4">
                        <i class="fas fa-book"></i>
                        <h1 class="display-5 fw-bold text-dark mb-3">Catalogue des livres</h1>
                    <p class="text-muted">
                        {{ $stats['totalLivres'] }} livres • {{ $stats['livresDisponibles'] }} disponibles • {{ $stats['totalCategories'] }} catégories
                    </p>
                </div>
                <div>
                    <a href="{{ route('livres.search') }}" class="btn btn-outline-primary">
                        <i class="fas fa-search"></i> Recherche avancée
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Liste des livres --}}
    <div class="row">
        @forelse($livres as $livre)
        <div class="col-md-6 col-lg-4 mb-4">
            <x-livre-card :livre="$livre" :show-details="true" />
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i>
                Aucun livre n'est disponible pour le moment.
            </div>
        </div>
        @endforelse
    </div>

    {{-- Message informatif --}}
    @if(count($livres) > 0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-light">
                <i class="fas fa-lightbulb"></i>
                <strong>Information :</strong> 
                Ces données sont statiques pour la Séance 1. 
                En Séance 2, nous connecterons une vraie base de données PostgreSQL !
            </div>
        </div>
    </div>
    @endif
</div>
@endsection