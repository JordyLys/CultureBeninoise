@extends(Auth::check() ? 'layouts.admin' : 'layouts.front')

@section('title')
    <div class="row mb-3">
        <div class="col-sm-6">
            <h3 class="mb-0">Liste des contenus</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#" class="text-theme">Contenus</a></li>
                <li class="breadcrumb-item active text-theme" aria-current="page">Index</li>
            </ol>
        </div>
    </div>
@endsection

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if (session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@section('content')
    {{-- Bouton "Nouveau" en haut à droite --}}
    <div class="btn-container d-flex justify-content-end mb-3" style="margin-top: 1rem;">
        <a href="{{ route('contenus.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nouveau
        </a>
    </div>

    {{-- Container global pour tout le contenu --}}
    <div class="contenus-container px-3">
        @php
            $contenusParType = $contenus->groupBy(fn($contenu) => $contenu->typeContenu->nom);
        @endphp

        @foreach ($contenusParType as $type => $contenusType)
            <div class="mb-5">
                <h4 class="mb-3">{{ $type }}</h4>
                <div class="row g-4">
                    @foreach ($contenusType as $contenu)
                        @php
                            if (!$contenu) {
                                continue;
                            }

                            $urlVoirPlus = route('front.abonnement.show', $contenu->id);
                            $langue = optional($contenu->langue)->nom;
                            $region = optional($contenu->region)->nom;

                            $firstMedia =
                                $contenu->media && $contenu->media->count() > 0 ? $contenu->media->first() : null;
                        @endphp

                        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                            <div class="card card-modern h-100 shadow-sm position-relative overflow-hidden">

                                {{-- MEDIA EN HAUT --}}
                                @if ($contenu->media)
                                    @if ($contenu->media->idTypeMedia == 1)
                                        <img src="{{ asset($contenu->media->chemin) }}" class="card-img-top"
                                            style="height:180px; object-fit:cover;" alt="{{ $contenu->titre }}">
                                    @elseif ($contenu->media->idTypeMedia == 2)
                                        <video height="180" style="width:100%; object-fit:cover;" controls>
                                            <source src="{{ asset($contenu->media->chemin) }}" type="video/mp4">
                                            Votre navigateur ne supporte pas la vidéo.
                                        </video>
                                    @endif
                                @endif
                                {{-- BADGES LANGUE & REGION --}}
                                <div class="badge-container position-absolute top-0 start-0 m-2 d-flex flex-wrap gap-1">
                                    @if ($langue)
                                        <span class="badge badge-langue">{{ $langue }}</span>
                                    @endif
                                    @if ($region)
                                        <span class="badge badge-region">{{ $region }}</span>
                                    @endif
                                </div>

                                {{-- BODY --}}
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="card-title">{{ $contenu->titre }}</h5>
                                    <p class="card-text text-muted flex-grow-1">
                                        {{ \Illuminate\Support\Str::limit($contenu->texte, 120) }}
                                    </p>

                                    <a href="{{ Auth::check() ? route('front.contenu.show', $contenu->id) : $urlVoirPlus }}"
                                        class="btn btn-outline-primary btn-sm w-100 d-flex justify-content-between align-items-center mt-2">
                                        Voir plus <i class="fas fa-arrow-right"></i>
                                    </a>

                                    <small
                                        class="text-muted mt-2 d-block text-end">{{ $contenu->dateCreation?->format('d/m/Y') }}</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection

@push('styles')
    <style>
        .badge-container {
            padding-top: 5rem;
        }

        /* Container global avec padding horizontal */


        /* ===== CARDS MODERNES ===== */
        .card-modern {
            border-radius: 14px;
            background-color: #fff;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .card-modern:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        /* MEDIA UNIFORME */
        .media-card {
            width: 100%;
            height: 180px;
            object-fit: cover;
        }

        /* BADGES */
        .badge-container .badge {
            font-size: 0.65rem;
            padding: 0.3em 0.5em;
            border-radius: 0.35rem;
            border: 1px solid #ddd;
            background-color: #f0f0f0;
            color: #333;
        }

        /* TITLES & TEXT */
        .card-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: #2d2d2d;
        }

        .card-text {
            font-size: 0.95rem;
            margin-bottom: 0.5rem;
        }

        /* BUTTONS */
        .btn-outline-primary {
            border-radius: 8px;
            font-size: 0.85rem;
            padding: 0.35rem 0.8rem;
        }

        /* ESPACEMENT ENTRE LES CARTES */
        .row.g-4 {
            row-gap: 1.5rem;
            column-gap: 1.5rem;
        }

        /* Container global avec padding horizontal augmenté */
        .contenus-container {
            padding-left: 2rem;
            /* plus de padding à gauche */
            padding-right: 2rem;
            /* plus de padding à droite */
        }

        /* Bouton "Nouveau" légèrement plus bas */
        .btn-container {
            margin-top: 1rem;
            margin-bottom: 1.5rem;
        }
    </style>
@endpush
