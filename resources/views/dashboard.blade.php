@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row">
        {{-- Barre latérale : Profil et Abonnement --}}
        <div class="col-md-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="fas fa-user-circle fa-5x text-primary"></i>
                    </div>
                    <h4 class="fw-bold">{{ auth()->user()->name }}</h4>
                    <p class="text-muted">{{ auth()->user()->email }}</p>
                    <span class="badge bg-primary px-3 py-2">Rôle : {{ ucfirst(auth()->user()->role) }}</span>
                    <hr>
                    <div class="d-grid">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100">Se déconnecter</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 border-start border-primary border-4">
                <div class="card-body">
                    <h6 class="text-uppercase text-muted small fw-bold">Mon Abonnement</h6>
                    <h5 class="fw-bold">{{ ucfirst(auth()->user()->subscription_type) }}</h5>
                    @if(auth()->user()->is_active)
                        <p class="text-success mb-2"><i class="fas fa-check-circle"></i> Compte Actif</p>
                        <p class="small text-muted">
                            Total mensuel : 
                            <strong>
                                @if(auth()->user()->subscription_type === 'famille')
                                    {{ 15 + (auth()->user()->children->count() * 5) }}€
                                @else
                                    15€
                                @endif
                            </strong>
                        </p>
                    @else
                        <p class="text-danger mb-0"><i class="fas fa-times-circle"></i> Inactif</p>
                        <a href="{{ route('tarifs') }}" class="btn btn-sm btn-primary mt-2">S'abonner</a>
                    @endif
                </div>
            </div>
        </div>

        {{-- Zone Principale --}}
        <div class="col-md-8">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(auth()->user()->subscription_type === 'famille')
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold text-primary"><i class="fas fa-users me-2"></i>Ma Famille</h5>
                        <a href="{{ route('tarifs') }}" class="btn btn-sm btn-outline-primary">Modifier l'offre</a>
                    </div>
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Mes enfants inscrits ({{ $children->count() }})</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nom</th>
                                        <th>Email (Identifiant)</th>
                                        <th>Date d'ajout</th>
                                        <th class="text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($children as $child)
                                        <tr>
                                            <td><i class="fas fa-child text-info me-2"></i>{{ $child->name }}</td>
                                            <td>{{ $child->email }}</td>
                                            <td>{{ $child->created_at->format('d/m/Y') }}</td>
                                            <td class="text-end">
                                                <form action="{{ route('child.delete', $child->id) }}" method="POST" onsubmit="return confirm('Supprimer ce compte enfant ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">Aucun enfant ajouté pour le moment.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <hr>

                        <h6 class="fw-bold mb-3 text-primary">Ajouter un profil enfant (+5€/mois)</h6>

                        {{-- Affichage des erreurs de validation (ex: email déjà pris) --}}
                        @if ($errors->any())
                            <div class="alert alert-danger py-2">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('subscription.add_child') }}" method="POST" class="bg-light p-3 rounded shadow-sm">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="small fw-bold">Nom de l'enfant</label>
                                    <input type="text" name="name" class="form-control" placeholder="Ex: Lucas" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="small fw-bold">Email (Identifiant)</label>
                                    <input type="email" name="email" class="form-control" placeholder="enfant@mail.com" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="small fw-bold">Mot de passe</label>
                                    <input type="password" name="password" class="form-control" placeholder="8 caractères min." required>
                                </div>
                                <div class="col-12 text-end mt-3">
                                    <button type="submit" class="btn btn-primary px-4">
                                        <i class="fas fa-plus me-2"></i>Enregistrer l'enfant
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                {{-- Abonnement Individuel --}}
                <div class="card shadow-sm border-0 p-5 text-center">
                    <div class="mb-3 text-warning">
                        <i class="fas fa-gem fa-4x"></i>
                    </div>
                    <h3 class="fw-bold">Profitez de votre lecture !</h3>
                    <p class="text-muted mx-auto" style="max-width: 500px;">
                        Vous avez un abonnement <strong>Individuel</strong>. Vous pouvez consulter l'intégralité du catalogue BiblioTech en illimité.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('livres.index') }}" class="btn btn-primary btn-lg px-5 shadow-sm mb-2">Parcourir le catalogue</a>
                        <br>
                        <a href="{{ route('tarifs') }}" class="btn btn-link text-decoration-none">Besoin d'ajouter des enfants ? Passer en offre Famille</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection