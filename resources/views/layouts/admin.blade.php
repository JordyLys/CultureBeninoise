<!doctype html>
<html lang="fr">

<head>
    <meta charset="utf-8" />
    <title>Culture Béninoise</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- AdminLTE / Bootstrap -->
    <link rel="stylesheet" href="{{ URL::asset('adminlte/css/adminlte.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />

    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f9fa;
            color: #212529;
        }

        /* SIDEBAR */
        .sidebar {
            position: fixed;
            top: 58px;
            /* même hauteur que la navbar */
            left: 0;
            width: 200px;
            height: calc(100vh - 58px);
            /* occupe tout l'écran sauf la navbar */
            background: #f8f9fa;
            overflow-y: auto;
            border-right: 1px solid #dee2e6;
            z-index: 1040;
        }


        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 6px;
            font-size: 15px;
            text-decoration: none;
            color: #212529;
        }

        .sidebar-link:hover {
            background: #e9ecef;
            transform: translateX(2px);
        }

        .sidebar-link.active {
            background: #d4edda;
            border-left: 3px solid #28a745;
        }

        .logout-btn {
            margin-top: 25px;
            display: block;
            background: #dc3545;
            color: white;
            padding: 12px;
            border-radius: 12px;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
        }

        .logout-btn:hover {
            background: #c82333;
        }

        /* HEADER */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 58px;
            /* Ajuste selon ta hauteur réelle */
            z-index: 1050;
            /* Au-dessus du sidebar et du contenu */
            background-color: #ffffff;
            border-bottom: 1px solid #dee2e6;
        }


        .app-main {
            margin-left: 240px;
            /* largeur du sidebar */
            padding: 80px 25px 40px;
            /* padding top pour ne pas cacher la navbar */
            min-height: 100vh;
        }

        /* Avatar initiales */
        .avatar-initiales {
            width: 40px;
            height: 40px;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 16px;
            text-transform: uppercase;
        }

        /* Table DataTables */
        table.dataTable {
            background: #ffffff;
            border-radius: 12px;
        }

        table.dataTable tbody tr:hover {
            background: #e9ecef;
        }

        .modal-content {
            background: #ffffff;
            border-radius: 12px;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <!-- Logo à gauche -->
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('adminlte/img/cultureBeninoise.png') }}" alt="Logo"
                    style="height: 50px; width:auto; border-radius:8px;">
                <span class="ms-2 fw-bold">Culture Béninoise</span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>


            {{-- Utilisateur connecté --}}
            <li class="nav-item dropdown ms-3">
                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">

                    {{-- Avatar ou initiales --}}
                    @if (Auth::user()->avatar)
                        <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar"
                            class="rounded-circle me-2" style="width:40px; height:40px; object-fit:cover;">
                    @else
                        @php
                            $initiales = strtoupper(
                                substr(Auth::user()->prenom, 0, 1) . substr(Auth::user()->nom, 0, 1),
                            );
                            $colors = ['#D62828', '#FCBF49', '#007F5F', '#6A4C93', '#FF6F61', '#FFB400'];
                            $index = Auth::user()->id % count($colors);
                            $color = $colors[$index];
                        @endphp
                        <div class="rounded-circle d-flex justify-content-center align-items-center me-2"
                            style="width:40px; height:40px; background:{{ $color }}; color:white; font-weight:bold;">
                            {{ $initiales }}
                        </div>
                    @endif

                    {{-- Nom complet --}}
                    <span>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</span>
                </a>

                {{-- Dropdown menu --}}
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                    </li>
                    <li>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger" type="submit">Déconnexion</button>
                        </form>
                    </li>
                </ul>
            </li>
        </div>
    </nav>
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <div class="sidebar-content" style="padding-top:20px;">
            @if (Auth::check() && Auth::user()->role->nom === 'Admin')
                <!-- Menu Admin -->
                <a href="{{ route('dashboard') }}"
                    class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i><span>Dashboard</span>
                </a>
                <a href="{{ route('home') }}"
                    class="sidebar-link {{ request()->routeIs('acceuil') ? 'active' : '' }}"><i
                        class="bi bi-house-fill"></i><span>Accueil</span></a>
                <a href="{{ route('front.abonnement') }}"
                    class="sidebar-link {{ request()->routeIs('abonnement') ? 'active' : '' }}"><i
                        class="bi bi-card-list"></i><span>Mon Abonnement</span></a>

                <a class="sidebar-link" data-bs-toggle="collapse" href="#generalSubmenu"><i
                        class="bi bi-list-ul"></i><span>Généralités</span></a>
                <div class="collapse {{ request()->routeIs('langues.*', 'regions.*', 'users.*', 'contenus.*', 'commentaires.*', 'medias.*') ? 'show' : '' }}"
                    id="generalSubmenu">
                    <ul class="nav flex-column ms-4">
                        <li><a href="{{ route('langues.index') }}"
                                class="sidebar-link {{ request()->routeIs('langues.*') ? 'active' : '' }}"><i
                                    class="bi bi-translate"></i><span>Langues</span></a></li>
                        <li><a href="{{ route('regions.index') }}"
                                class="sidebar-link {{ request()->routeIs('regions.*') ? 'active' : '' }}"><i
                                    class="bi bi-geo-alt-fill"></i><span>Régions</span></a></li>
                        <li><a href="{{ route('users.index') }}"
                                class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}"><i
                                    class="bi bi-people-fill"></i><span>Utilisateurs</span></a></li>
                        <li><a href="{{ route('admin.contenus.index') }}"
                                class="sidebar-link {{ request()->routeIs('contenus.*') ? 'active' : '' }}"><i
                                    class="bi bi-file-earmark-text-fill"></i><span>Contenus</span></a></li>
                        <li><a href="{{ route('commentaires.index') }}"
                                class="sidebar-link {{ request()->routeIs('commentaires.*') ? 'active' : '' }}"><i
                                    class="bi bi-chat-left-text-fill"></i><span>Commentaires</span></a></li>
                        <li><a href="{{ route('medias.index') }}"
                                class="sidebar-link {{ request()->routeIs('medias.*') ? 'active' : '' }}"><i
                                    class="bi bi-image-fill"></i><span>Médias</span></a></li>
                    </ul>
                </div>
                <a class="sidebar-link" data-bs-toggle="collapse" href="#typeSubmenu"><i
                        class="bi bi-tags-fill"></i><span>Type</span></a>
                <div class="collapse {{ request()->routeIs('typeMedias.*', 'typeContenus.*') ? 'show' : '' }}"
                    id="typeSubmenu">
                    <ul class="nav flex-column ms-4">
                        <li><a href="{{ route('typeMedias.index') }}"
                                class="sidebar-link {{ request()->routeIs('typeMedias.*') ? 'active' : '' }}"><i
                                    class="bi bi-image"></i><span>Type Médias</span></a></li>
                        <li><a href="{{ route('typeContenus.index') }}"
                                class="sidebar-link {{ request()->routeIs('typeContenus.*') ? 'active' : '' }}"><i
                                    class="bi bi-file-earmark-text"></i><span>Type Contenus</span></a></li>
                    </ul>
                </div>
            @else
                <!-- Menu Utilisateur -->
                <a href="{{ route('home') }}"
                    class="sidebar-link {{ request()->routeIs('acceuil') ? 'active' : '' }}"><i
                        class="bi bi-house-fill"></i><span>Accueil</span></a>
                <a href="{{ route('front.abonnement') }}"
                    class="sidebar-link {{ request()->routeIs('abonnement') ? 'active' : '' }}"><i
                        class="bi bi-card-list"></i><span>Mon Abonnement</span></a>
                <a href="{{ route('front.contenus.index') }}"
                    class="sidebar-link {{ request()->routeIs('contenus.*') ? 'active' : '' }}"><i
                        class="bi bi-file-earmark-text-fill"></i><span>Contenus</span></a>
            @endif
        </div>
    </aside>

    <!-- MAIN -->
    <main class="app-main">
        @yield('title')
        @yield('content')
    </main>

    <!-- JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const activeLink = document.querySelector('.sidebar-link.active');
            if (activeLink) activeLink.scrollIntoView({
                behavior: "smooth",
                block: "center"
            });

            $(document).ready(function() {
                $('table').DataTable({
                    paging: true,
                    searching: true,
                    ordering: false,
                    responsive: true,
                    info: false,
                    language: {
                        decimal: ",",
                        emptyTable: "Aucune donnée disponible dans le tableau",
                        search: "Rechercher :",
                        paginate: {
                            first: "Premier",
                            last: "Dernier",
                            next: "Suivant",
                            previous: "Précédent"
                        },
                    }
                });
            });
        });
    </script>
</body>

</html>
