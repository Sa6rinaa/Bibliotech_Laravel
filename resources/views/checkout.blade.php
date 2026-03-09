@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-primary text-white py-3 text-center">
                    <h4 class="mb-0">Finaliser mon abonnement</h4>
                    <span class="badge bg-light text-primary mt-2">Mode Test</span>
                </div>
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <h5>Formule choisie : <span class="text-primary">{{ ucfirst($plan) }}</span></h5>
                        <p class="text-muted">Montant à régler : <strong>{{ $plan === 'individuel' ? '15,00' : '20,00' }} €</strong></p>
                    </div>

                    <form action="{{ route('subscription.subscribe', $plan) }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nom sur la carte</label>
                            <input type="text" class="form-control form-control-lg" placeholder="SABRINA" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Numéro de carte</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white"><i class="fas fa-credit-card text-muted"></i></span>
                                <input type="text" class="form-control form-control-lg" placeholder="4242 4242 4242 4242" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-7 mb-3">
                                <label class="form-label fw-bold small">Expiration (MM/YY)</label>
                                <input type="text" class="form-control form-control-lg" placeholder="12/26" required>
                            </div>
                            <div class="col-5 mb-4">
                                <label class="form-label fw-bold small">CVC</label>
                                <input type="text" class="form-control form-control-lg" placeholder="123" required>
                            </div>
                        </div>

                        <div class="alert alert-secondary py-2 small border-0">
                            <i class="fas fa-lock me-2 text-success"></i> Vos données sont chiffrées (Simulation de test).
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100 shadow-sm mt-2">
                            Confirmer le paiement
                        </button>
                        
                        <a href="{{ route('tarifs') }}" class="btn btn-link w-100 text-muted mt-2 small">Annuler et revenir en arrière</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection