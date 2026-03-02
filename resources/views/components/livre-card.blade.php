{{-- Composant carte livre pour BiblioTech --}}
<div class="card h-100 shadow-sm">
    <div class="book-cover book-cover-{{ $livre->categorie->slug ?? 'default' }}">
        <div class="book-title">{{ $livre->titre ?? 'Livre' }}</div>
    </div>

    <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $livre->titre ?? 'Titre non disponible' }}</h5>
        <p class="card-text text-muted">{{ $livre->auteur ?? 'Auteur inconnu' }}</p>

        @if ($livre->categorie)
            <span class="badge mb-2" style="background-color: {{ $livre->categorie->couleur }}; width: fit-content;">
                <i class="{{ $livre->categorie->icone }}"></i>
                {{ $livre->categorie->nom }}
            </span>
        @endif

        <div class="mt-auto">
            <a href="{{ route('livres.show', $livre->id) }}" class="btn btn-primary">
                <i class="fas fa-eye"></i> Voir détails
            </a>
        </div>
    </div>
</div>
