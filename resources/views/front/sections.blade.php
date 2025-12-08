@extends('layouts.front')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-capitalize">{{ $slug }}</h2>

    <div class="row g-4">
        @foreach ($contenus as $contenu)
            @include('front.card', ['contenu' => $contenu])
        @endforeach
    </div>

    <div class="mt-3">
        {{ $contenus->links() }}
    </div>
</div>
@endsection
