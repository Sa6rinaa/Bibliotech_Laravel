@extends('layouts.app', [
    'title' => $livre->titre,
    'breadcrumbs' => [['label' => 'Catalogue', 'url' => route('livres.index')], ['label' => $livre->titre, 'url' => null]],
])

@section('content')
    <div class="container">
        <div class="row">
            {{-- Image du livre --}}
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="book-cover book-cover-{{ $livre->categorie->slug ?? 'default' }}" style="height: 400px;">
                        <div class="book-title" style="font-size: 18px;">{{ $livre->titre }}</div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="d-grid gap-2 mt-3">
                    @if ($livre->disponible)
                        <button class="btn btn-success">
                            <i class="fas fa-hand-holding"></i> Emprunter
                            <small>(Séance 4)</small>
                        </button>
                    @else
                        <button class="btn btn-warning" disabled>
                            <i class="fas fa-clock"></i> Non disponible
                        </button>
                    @endif

                    <button class="btn btn-outline-secondary">
                        <i class="fas fa-heart"></i> Ajouter aux favoris
                        <small>(Séance 5)</small>
                    </button>
                </div>
            </div>

            {{-- Détails du livre --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h1 class="mb-0">{{ $livre->titre }}</h1>
                        @if ($livre->disponible)
                            <span class="badge bg-success fs-6">Disponible</span>
                        @else
                            <span class="badge bg-warning fs-6">Emprunté</span>
                        @endif
                    </div>

                    <div class="card-body">
                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h5><i class="fas fa-user"></i> Auteur</h5>
                                <p>{{ $livre->auteur }}</p>
                            </div>
                            <div class="col-sm-6">
                                <h5><i class="fas fa-tag"></i> Catégorie</h5>
                                <span class="badge"
                                    style="background-color: {{ $livre->categorie->couleur ?? '#6c757d' }}">
                                    <i class="{{ $livre->categorie->icone ?? 'fas fa-tag' }}"></i>
                                    {{ $livre->categorie->nom ?? 'Non catégorisé' }}
                                </span>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-sm-6">
                                <h5><i class="fas fa-barcode"></i> ISBN</h5>
                                <p><code>{{ $livre->isbn }}</code></p>
                            </div>
                            <div class="col-sm-6">
                                <h5><i class="fas fa-calendar"></i> Année</h5>
                                <p>{{ $livre->annee }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <h5><i class="fas fa-file-text"></i> Résumé</h5>
                            <p>{{ $livre->resume }}</p>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <h6><i class="fas fa-file-alt"></i> Pages</h6>
                                <p>{{ $livre->nb_pages }} pages</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Livres similaires --}}
        @if (isset($livresAssocies) && count($livresAssocies) > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <h3><i class="fas fa-similar"></i> Livres similaires</h3>
                    <p class="text-muted">Autres livres de la catégorie "{{ $livre->categorie->nom }}"</p>
                </div>

                @foreach ($livresAssocies as $livreAssocie)
                    <div class="col-md-4 mb-3">
                        <x-livre-card :livre="$livreAssocie" />
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
