{{-- Composant carte livre réutilisable --}}
@props(['livre', 'showDetails' => false])

<div class="card h-100 shadow-sm">
    <div class="book-cover book-cover-{{ $livre->categorie->slug ?? 'default' }}" style="height: 200px;">
        <div class="book-title">{{ $livre->titre }}</div>
    </div>

    <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $livre->titre }}</h5>
        <p class="card-text text-muted">
            <i class="fas fa-user"></i> {{ $livre->auteur }}
        </p>

        @if ($livre->categorie)
            <span class="badge mb-2" style="background-color: {{ $livre->categorie->couleur }}; width: fit-content;">
                <i class="{{ $livre->categorie->icone }}"></i>
                {{ $livre->categorie->nom }}
            </span>
        @endif

        @if ($showDetails && $livre->resume)
            <p class="card-text">{{ Str::limit($livre->resume, 100) }}</p>
        @endif

        <div class="mt-auto">
            @if ($livre->disponible)
                <span class="badge bg-success mb-2">
                    <i class="fas fa-check"></i> Disponible
                </span>
            @else
                <span class="badge bg-warning mb-2">
                    <i class="fas fa-clock"></i> Emprunté
                </span>
            @endif

            <div class="d-grid">
                <a href="{{ route('livres.show', $livre->id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-eye"></i> Voir détails
                </a>
            </div>
        </div>
    </div>
</div>
