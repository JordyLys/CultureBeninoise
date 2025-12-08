
@php
use Illuminate\Support\Facades\Auth;

if (!$contenu) return;

$urlVoirPlus = route('front.abonnement.show', $contenu->id);
$langue = optional($contenu->langue)->nom;
$region = optional($contenu->region)->nom;
@endphp

<div class="col-md-3 mb-4">
    <div class="card shadow-sm border-0 overflow-hidden position-relative h-100"
         style="border-radius:12px; transition: transform 0.2s, box-shadow 0.2s; background:#fff;">

        {{-- MEDIA EN HAUT --}}
        @if ($contenu->media)
    @if ($contenu->media->idTypeMedia == 1)
        <img src="{{ asset($contenu->media->chemin) }}"
             class="card-img-top"
             style="height:180px; object-fit:cover;"
             alt="{{ $contenu->titre }}">
    @elseif ($contenu->media->idTypeMedia == 2)
        <video height="180" style="width:100%; object-fit:cover;" controls>
            <source src="{{ asset($contenu->media->chemin) }}" type="video/mp4">
            Votre navigateur ne supporte pas la vidéo.
        </video>
    @endif
@endif

        {{-- BADGES LANGUE & REGION --}}
        <div style="position:absolute; top:10px; left:10px; display:flex; gap:4px; flex-wrap:wrap;">
            @if($langue)
                <span class="badge badge-langue">{{ $langue }}</span>
            @endif
            @if($region)
                <span class=" badge badge-region">{{ $region }}</span>
            @endif
        </div>

        <div class="card-body d-flex flex-column justify-content-between">
            <h5 class="card-title" style="font-weight:600; font-size:1.1rem; color:#333;">
                {{ $contenu->titre }}
            </h5>

            <p class="card-text text-muted" style="flex-grow:1; font-size:0.95rem;">
                {{ \Illuminate\Support\Str::limit($contenu->texte, 100) }}
            </p>

            <a href={{ $urlVoirPlus }}
               class="btn btn-outline-primary btn-sm w-100 mt-2 d-flex justify-content-between align-items-center">
                Voir plus
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

@push('styles')
<style>
.card:hover {
    transform: translateY(-3px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}
.badge {
    font-size: 0.7rem;
    padding: 0.3em 0.5em;
    border-radius:0.35rem;
    border: 1px solid #ddd;
}
</style>
@endpush
