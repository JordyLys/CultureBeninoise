<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <!-- Logo à gauche -->
        <a class="navbar-brand d-flex align-items-center" href={{ route('home') }}>
            <img src="{{ asset('adminlte/img/cultureBeninoise.png') }}" alt="Logo"
                style="height: 50px; width:auto; border-radius:8px;">
            <span class="ms-2 fw-bold">Culture Béninoise</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Liens à droite -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center w-100 justify-content-end flex-nowrap">
               <li class="nav-item"> <a class="nav-link" href="{{ route('front.contenus.index') }}">Contenus</a></li>
                <li class="nav-item"><a class="nav-link" href="#histoire">Histoire</a></li>
                <li class="nav-item"><a class="nav-link" href="#conte">Conte</a></li>
                <li class="nav-item"><a class="nav-link" href="#recette">Recettes</a></li>
                <li class="nav-item"><a class="nav-link" href="#danse">Danses</a></li>
                <li class="nav-item"><a class="nav-link" href="#rituel">Rituels</a></li>

                @guest
                    {{-- Utilisateur non connecté --}}
                    <li class="nav-item ms-5">
                        <a class="nav-link" href="{{ route('register') }}">Je m'inscris
                            <i class="fas fa-pencil-alt ms-2"></i>
                        </a>
                    </li>
                    <li class="nav-item ms-3">
                        <a class="nav-link" href="{{ route('login') }}">Je me connecte
                            <i class="fas fa-user-circle ms-2"></i>
                        </a>
                    </li>
                @else
                    {{-- Utilisateur connecté --}}
                  @php
    $user = Auth::user();
@endphp

@if ($user->role && strtolower($user->role->nom) === 'admin')
    <li class="nav-item ms-3">
        <a class="btn btn-primary" href="{{ route('dashboard') }}">Mon Compte</a>
    </li>
@else
    <li class="nav-item ms-3">
        <a class="btn btn-primary" href="{{ route('front.contenus.index') }}">Mon Compte</a>
    </li>
@endif




                @endguest

            </ul>
        </div>
    </div>
</nav>
