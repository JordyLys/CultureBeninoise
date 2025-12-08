<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Culture Béninoise')</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --background-color: #ffeef0;
            --primary-color: #ff7a00;
            --secondary-color: #198754;
            --text-color: #333;
            --text-muted: #666;
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            font-family: 'Segoe UI', sans-serif;
        }

        ul,
        li {
            list-style: none !important;
            padding: 0;
            margin: 0;
        }


        /* --- BOUTONS --- */
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #e56f00;
        }

        .btn-primary:focus,
        .btn-primary:active,
        .btn-primary:focus-visible {
            box-shadow: none !important;
            outline: none !important;
        }

        /* --- NAVBAR --- */
        .navbar {
            height: 80px;
            padding: 0 2rem;
            font-size: 1.1rem;
            background-color: var(--background-color);
            color: var(--text-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar .nav-link {
            color: var(--text-color);
            padding: 0.5rem 0.8rem;
            font-weight: 500;
            font-size: 0.9rem;
            border-bottom: 2px solid transparent;
            transition: border-color 0.3s, color 0.3s;
            white-space: nowrap;
        }

        .navbar .nav-link:hover,
        .navbar .nav-link:focus {
            color: var(--primary-color) !important;
            border-bottom: 2px solid #ffeef0;
        }

        .navbar-brand {
            font-size: 1.5rem;
            font-weight: bold;
            display: flex;
            align-items: center;
        }

        .navbar li::before,
        .navbar li::marker {
            content: "" !important;
        }

        .navbar * {
            list-style: none !important;
        }


        .navbar-brand img {
            height: 60px;
            width: auto;
            border-radius: 12px;
            margin-right: 15px;
        }

        /* --- HERO --- */
        .hero {
            position: relative;
            height: 78vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 30px;
        }

        .hero-box {
            width: 90%;
            height: 100%;
            overflow: hidden;
            border-radius: 30px;
            position: relative;
        }

        .hero-box img.slide {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0;
            transition: opacity 0.8s ease-in-out;
        }

        .hero-box img.slide.active {
            opacity: 1;
            z-index: 1;
        }

        .hero-overlay {
            position: absolute;
            z-index: 10;
            text-align: center;
            color: white;
            width: 70%;
        }

        .hero-overlay h1 {
            font-size: 2.8rem;
            font-weight: bold;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.8);
        }

        .hero-overlay p {
            font-size: 1.1rem;
            margin-bottom: 18px;
            text-shadow: 0 4px 10px rgba(0, 0, 0, 0.7);
        }

        /* --- CARDS --- */


        .card-section {
            padding: 6rem 0;
        }

        .card-section .card {
            /* border-radius: 12px;*/
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s, box-shadow 0.3s;
        }



        .card-title {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .card-text {
            font-size: 0.9rem;
            color: #555;
        }

        .badge {
            font-size: 0.85rem;

            padding: 6px 10px;

            border-radius: 6px;
        }

        .badge-type {
            background-color: #f2f2f2;
            color: #555;
        }

        .badge-langue {
            background-color: #eef7ff;
            color: #336699;
        }

        .badge-region {
            background-color: #fff5e6;
            color: #cc8800;
        }

        /* Sections couleurs très légères */
        .section-1 {
            background-color: #fff7f8;
        }

        .section-2 {
            background-color: #f7fdf9;
        }

        .section-3 {
            background-color: #fffaf2;
        }

        .section-4 {
            background-color: #f8fbff;
        }

        .section-5 {
            background-color: #fbf8ff;
        }
        /* Sections */


.card-section h2 {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 20px;
    color: #333;
}

.card-section .btn-outline-primary {
    font-weight: 500;
    border-radius: 50px;
    padding: 6px 20px;
    transition: all 0.3s ease;
}

.card-section .btn-outline-primary:hover {
    background-color: #007bff;
    color: #fff;
    text-decoration: none;
}

/* Cards */
.card-custom {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    transition: transform 0.3s, box-shadow 0.3s;
    display: flex;
    flex-direction: column;
    background-color: #fff;
    height: 100%;
}

.card-custom:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.12);
}

.card-custom img,
.card-custom video {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.card-custom .card-body {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 15px;
}

.card-custom .card-title {
    font-size: 1.1rem;
    font-weight: 600;
    margin-bottom: 8px;
    color: #333;
}

.card-custom .card-text {
    font-size: 0.95rem;
    color: #555;
    flex-grow: 1;
    margin-bottom: 10px;
}

.card-custom .badge {
    font-size: 0.7rem;
    padding: 0.3em 0.6em;
    border-radius: 0.35rem;
    border: 1px solid #ddd;
    background-color: #f1f1f1;
    color: #333;
    margin-right: 5px;
}

/* Responsive grid */
@media (min-width: 768px) {
    .card-col {
        flex: 0 0 48%;
        max-width: 48%;
    }
}

@media (min-width: 992px) {
    .card-col {
        flex: 0 0 23%;
        max-width: 23%;
    }
}


        /* --- FOOTER (original) --- */
        footer {
            background-color: #222222;
            color: #fff;
            padding: 3rem 0 1.5rem;
            font-family: 'Segoe UI', sans-serif;
        }

        footer a {
            color: #bbbbbb;
            text-decoration: none;
            transition: color 0.3s;
        }

        footer a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        .footer-top {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: flex-start;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .footer-brand {
            flex: 1 1 250px;
        }

        .footer-brand img {
            height: 60px;
            width: auto;
            border-radius: 12px;
            margin-bottom: 1rem;
        }

        .footer-brand p {
            font-size: 1rem;
            color: #ccc;
        }

        .footer-links {
            display: flex;
            flex: 3 1 600px;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .footer-column h5 {
            font-size: 1.1rem;
            margin-bottom: 1rem;
            color: #fff;
        }

        .footer-column ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-column ul li {
            margin-bottom: 0.6rem;
        }

        .footer-column ul li a {
            font-size: 0.95rem;
        }

        hr {
            border: 0;
            border-top: 1px solid #999999;
            width: 90%;
            margin: 1rem auto;
        }

        .footer-bottom {
            text-align: center;
            font-size: 0.9rem;
            color: #aaa;
        }

        .social-links {
            list-style: none;
            padding: 0;
            font-size: 4rem;
            display: flex;
            gap: 25px;
            justify-content: center;
            /* centre horizontalement */
            margin: -10px 0 0;
            /* remonte le bloc social */
        }

        .social-links li a {
            color: #bbbbbb;
            font-size: 4rem;
            /* taille fixe des icônes */
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.3s;
        }

        .social-links li a:hover {
            color: #ffffff;
            /* seulement change la couleur au hover */
            transform: none;
            /* pas de zoom */
        }

        html {
            scroll-behavior: smooth;
        }
    </style>

    @stack('styles')
</head>

<body>
    @include('partials.front.navbar')

    <main>
        @yield('content')
    </main>

    @include('partials.front.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
