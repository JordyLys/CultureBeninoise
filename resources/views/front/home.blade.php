@extends('layouts.front')

@section('content')

<!-- Hero -->
<section id="hero" class="hero">
    <div class="hero-box">
        <img src="{{ asset('adminlte/img/ouidah.jpg') }}" alt="" class="slide active">
        <img src="{{ asset('adminlte/img/mur.jpg') }}" alt="" class="slide">
        <img src="{{ asset('adminlte/img/marche.jpg') }}" alt="" class="slide">
        <img src="{{ asset('adminlte/img/nonRetour.jpg') }}" alt="" class="slide">
        <img src="{{ asset('adminlte/img/atassii.jpg') }}" alt="" class="slide">
        <img src="{{ asset('adminlte/img/ablo.jpg') }}" alt="" class="slide">
        <img src="{{ asset('adminlte/img/porto.jpg') }}" alt="" class="slide">
        <img src="{{ asset('adminlte/img/food.jpg') }}" alt="" class="slide">
        <img src="{{ asset('adminlte/img/ghoost.jpg') }}" alt="" class="slide">
    </div>

<div class="hero-overlay">
    <h1 style="color:#fff8e1; text-shadow: 2px 2px 10px rgba(0,0,0,0.7);">
        Plongez au cœur de la culture béninoise
    </h1>
    <p style="color:#fff8e1; text-shadow: 1px 1px 8px rgba(0,0,0,0.6);">
        Explorez traditions, contes et saveurs qui font vibrer le Bénin.
    </p>
    <a href="#histoire" class="btn btn-primary btn-lg">Commencer l'aventure</a>
</div>

</section>

{{-- SECTION : HISTOIRE --}}

<section id="histoire" class="card-section section-1">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Histoires</h2>

            {{-- FLÈCHE À DROITE --}}
            <a href="{{ route('front.contenus.section', 'Histoire') }}"
               class="btn btn-outline-primary">
                Voir tout →
            </a>
        </div>

        <div class="row">
            @foreach($sections['histoire'] as $contenu)
                @include('front.card', ['contenu' => $contenu])
            @endforeach
        </div>
    </div>
</section>


{{-- SECTION : CONTE --}}
<section id="conte" class="card-section section-2">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Contes</h2>

            {{-- FLÈCHE À DROITE --}}
            <a href="{{ route('front.contenus.section', 'Conte') }}"
               class="btn btn-outline-primary">
                Voir tout →
            </a>
        </div>

        <div class="row">
            @foreach($sections['conte'] as $contenu)
                @include('front.card', ['contenu' => $contenu])
            @endforeach
        </div>
    </div>
</section>


{{-- SECTION : RECETTE --}}

<section id="recette" class="card-section section-3">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Recettes</h2>

            {{-- FLÈCHE À DROITE --}}
            <a href="{{ route('front.contenus.section', 'Recette') }}"
               class="btn btn-outline-primary">
                Voir tout →
            </a>
        </div>

        <div class="row d-flex flex-wrap justify-content-start">
            @foreach($sections['recette'] as $contenu)
                @include('front.card', ['contenu' => $contenu])
            @endforeach
        </div>
    </div>
</section>


{{-- SECTION : DANSE --}}




{{-- SECTION : RITUEL --}}

<section id="rituel" class="card-section section-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Rituels</h2>

            {{-- FLÈCHE À DROITE --}}
            <a href="{{ route('front.contenus.section', 'Rituel') }}"
               class="btn btn-outline-primary">
                Voir tout →
            </a>
        </div>

        <div class="row">
            @foreach($sections['rituel'] as $contenu)
                @include('front.card', ['contenu' => $contenu])
            @endforeach
        </div>
    </div>
</section>


@endsection

@push('scripts')
<script>
    const slides = document.querySelectorAll('.hero-box .slide');
    let currentIndex = 0;

    setInterval(() => {
        slides[currentIndex].classList.remove('active');
        currentIndex = (currentIndex + 1) % slides.length;
        slides[currentIndex].classList.add('active');
    }, 3000);
</script>
<script>
/*document.querySelectorAll('.voir-plus').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        @guest
            // Modal Bootstrap pour inviter à se connecter
            const modalHtml = `
            <div class="modal fade" id="loginModal" tabindex="-1">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title">Connexion requise</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <p>Vous devez être connecté pour voir ce contenu.</p>
                  </div>
                  <div class="modal-footer">
                    <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                  </div>
                </div>
              </div>
            </div>`;
            document.body.insertAdjacentHTML('beforeend', modalHtml);
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
        @else
            window.location.href = this.href;
        @endguest
    });
});*/
</script>

@endpush
