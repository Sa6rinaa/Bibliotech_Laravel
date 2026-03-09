@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="text-center mb-5">
        <h1 class="display-4 fw-bold text-primary">Nos Abonnements</h1>
        <p class="lead text-muted">Choisissez la formule qui vous convient pour accéder à tout le catalogue.</p>
    </div>

    <div class="row row-cols-1 row-cols-md-2 g-4 justify-content-center">
        <div class="col" style="max-width: 400px;">
            <div class="card h-100 shadow-lg border-primary">
                <div class="card-header bg-primary text-white text-center py-3">
                    <h3 class="my-0">Individuel</h3>
                </div>
                <div class="card-body text-center d-flex flex-column">
                    <h2 class="card-title pricing-card-title">15€<small class="text-muted fw-light">/mois</small></h2>
                    <ul class="list-unstyled mt-3 mb-4 text-start mx-auto">
                        <li class="mb-2">✅ Accès illimité à toutes les BD</li>
                        <li class="mb-2">✅ 1 Compte Adulte</li>
                        <li class="mb-2">✅ Lecture sur tous supports</li>
                    </ul>
                    
                    <div class="mt-auto">
                        @auth
                            @if(auth()->user()->subscription_type === 'individuel' && auth()->user()->is_active)
                                <button class="btn btn-lg btn-success w-100 disabled text-white">Plan Actuel</button>
                            @else
                                <a href="{{ route('checkout', 'individuel') }}" class="btn btn-lg btn-outline-primary w-100">Choisir ce plan</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-lg btn-outline-primary w-100">Connectez-vous pour souscrire</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>

        <div class="col" style="max-width: 400px;">
            <div class="card h-100 shadow-lg border-info">
                <div class="card-header bg-info text-white text-center py-3">
                    <h3 class="my-0">Famille</h3>
                </div>
                <div class="card-body text-center d-flex flex-column">
                    <h2 class="card-title pricing-card-title">15€ + 5€<small class="text-muted fw-light">/enfant</small></h2>
                    <ul class="list-unstyled mt-3 mb-4 text-start mx-auto">
                        <li class="mb-2">✅ Tout le catalogue pour l'adulte</li>
                        <li class="mb-2">✅ **Profils Enfants** dédiés</li>
                        <li class="mb-2">✅ Contrôle parental inclus</li>
                        <li class="mb-2">✅ Gestion simplifiée du foyer</li>
                    </ul>

                    <div class="mt-auto">
                        @auth
                            @if(auth()->user()->subscription_type === 'famille' && auth()->user()->is_active)
                                <button class="btn btn-lg btn-success w-100 disabled text-white">Plan Actuel</button>
                            @else
                                <a href="{{ route('checkout', 'famille') }}" class="btn btn-lg btn-info text-white w-100">Choisir ce plan</a>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="btn btn-lg btn-info text-white w-100">Connectez-vous pour souscrire</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger mt-4 text-center shadow-sm">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
        </div>
    @endif
</div>
@endsection