@extends('layouts.app', [
    'title' => 'Recherche de livres',
    'breadcrumbs' => [
        ['label' => 'Catalogue', 'url' => route('livres.index')],
        ['label' => 'Recherche', 'url' => null],
    ],
])

@section('content')
<div class="container">
    <h1>Recherche de livres</h1>
    {{-- Template minimaliste pour tests --}}
    @if(isset($query) && $query !== null)
        <p>Vous avez recherché : {{ $query }}</p>
    @endif
</div>
@endsection
