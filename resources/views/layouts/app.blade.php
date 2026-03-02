<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ isset($title) ? $title . ' - ' : '' }}BiblioTech</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Styles personnalisés -->
    <style>
        .navbar-brand {
            font-weight: 600;
        }
        .card {
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        
        /* Styles pour les couvertures de livres */
        .book-cover {
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 20px;
            box-shadow: inset 0 0 20px rgba(0,0,0,0.1);
        }
        
        .book-title {
            font-size: 16px;
            line-height: 1.3;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
        
        .book-cover-laravel {
            background: linear-gradient(135deg, #FF6B35 0%, #F7931E 100%);
        }
        
        .book-cover-docker {
            background: linear-gradient(135deg, #0EA5E9 0%, #0284C7 100%);
        }
        
        .book-cover-mvc, .book-cover-php {
            background: linear-gradient(135deg, #8B5CF6 0%, #7C3AED 100%);
        }
        
        .book-cover-default {
            background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
        }
        
        .book-cover::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="1" opacity="0.1"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>') no-repeat center center;
            background-size: 60px 60px;
        }
    </style>
</head>
<body class="bg-light">
    
    {{-- Navigation --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <i class="fas fa-book-open me-2"></i>
                <strong>BiblioTech</strong>
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fas fa-home"></i> Accueil
                        </a>
                    </li>
                    <li class="nav-item">
                                                <a class="nav-link" href="{{ route('livres.index') }}">
                            <i class="fas fa-book"></i> Catalogue
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                            <i class="fas fa-info-circle"></i> À propos
                        </a>
                    </li>
                </ul>
                
                {{-- Barre de recherche --}}
                <form class="d-flex" action="{{ route('livres.search') }}" method="GET">
                    <input class="form-control me-2" type="search" name="q" 
                           placeholder="Rechercher un livre..." value="{{ request('q') }}">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- Fil d'Ariane --}}
    @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
    <nav aria-label="breadcrumb" class="bg-white shadow-sm">
        <div class="container">
            <ol class="breadcrumb py-3 mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">
                        <i class="fas fa-home"></i> Accueil
                    </a>
                </li>
                @foreach($breadcrumbs as $breadcrumb)
                    @if($loop->last)
                        <li class="breadcrumb-item active">{{ $breadcrumb['label'] }}</li>
                    @else
                        <li class="breadcrumb-item">
                            <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['label'] }}</a>
                        </li>
                    @endif
                @endforeach
            </ol>
        </div>
    </nav>
    @endif

    {{-- Contenu principal --}}
    <main class="py-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-dark text-light mt-5">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-book-open"></i> BiblioTech</h5>
                    <p class="mb-0">Système de gestion de bibliothèque moderne avec Laravel.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">
                        Formation BTS SIO SLAM - Séance {{ isset($seance) ? $seance : '1' }}<br>
                        <small>Laravel {{ app()->version() }} • PHP {{ phpversion() }}</small>
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts personnalisés -->
    <script>
        // Auto-hide alerts after 5 seconds
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                var alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.style.display = 'none';
                });
            }, 5000);
        });
    </script>
    
    @stack('scripts')
</body>
</html>