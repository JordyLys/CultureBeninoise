<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abonnements - Culture Béninoise</title>

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #e07a1f;
            /* orange doux */
            --secondary-color: #f7f9fc;
            /* fond clair */
            --accent-blue: #3b82f6;
            /* bleu discret */
            --accent-green: #22c55e;
            /* vert discret */
            --text-color: #2d2d2d;
            --border-color: #e5e7eb;
        }

        body {
            background-color: var(--secondary-color);
            font-family: 'Segoe UI', Tahoma, sans-serif;
            color: var(--text-color);
        }

        .subscription-container {
            max-width: 650px;
            margin: 60px auto 80px;
            position: relative;
        }

        /* ===== FLÈCHE RETOUR ===== */
        .back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 30px;
            transition: color 0.2s ease;
        }

        .back-btn i {
            color: var(--primary-color);
        }

        .back-btn:hover {
            color: var(--primary-color);
        }

        h2 {
            text-align: center;
            font-weight: 700;
            margin-bottom: 70px;
            color: var(--primary-color);
            letter-spacing: 0.5px;
        }

        form {
            margin-bottom: 45px;
        }

        /* ===== CARDS ===== */
        .subscription-card {
            background: #fff;
            border-radius: 26px;
            padding: 60px 45px;
            /* padding large mais équilibré */
            min-height: 180px;
            /* hauteur de la card */
            display: flex;
            /* pour aligner icône + texte */
            flex-direction: column;
            /* éléments empilés verticalement */
            justify-content: center;
            width: 100%;
            text-align: left;
            position: relative;
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
            transition: all 0.35s ease;
            cursor: pointer;
        }

        /* décalage progressif */
        .card-offset-1 {
            transform: translateX(18px);
        }

        .card-offset-2 {
            transform: translateX(-22px);
        }

        .card-offset-3 {
            transform: translateX(28px);
        }

        .card-offset-4 {
            transform: translateX(-14px);
        }

        .subscription-card:hover {
            transform: translateY(-10px) scale(1.03);
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.18);
        }

        .subscription-card i {
            font-size: 1.7rem;
            margin-right: 12px;
        }

        .price {
            font-size: 1.8rem;
            font-weight: 800;
            display: flex;
            align-items: center;
            /* icône + texte alignés verticalement */
            gap: 12px;
        }

        .subscription-description {
            margin-top: 14px;
            font-size: 1.1rem;
            color: #555;
            overflow-wrap: break-word;
        }

        .duration-badge {
            position: absolute;
            top: 22px;
            right: 22px;
            padding: 8px 14px;
            border-radius: 18px;
            font-size: 0.9rem;
            font-weight: 600;
            color: #fff;
        }

        /* couleurs alternées badges + icônes */
        .badge-orange {
            background: var(--primary-color);
        }

        .badge-blue {
            background: var(--accent-blue);
        }

        .badge-green {
            background: var(--accent-green);
        }

        .icon-orange {
            color: var(--primary-color);
        }

        .icon-blue {
            color: var(--accent-blue);
        }

        .icon-green {
            color: var(--accent-green);
        }

        button.subscription-card {
            border: none;
            background: none;
            padding: 0;
        }
    </style>
</head>

<body>

    <div class="subscription-container">

        <!-- Flèche retour -->
        <a href="{{ url()->previous() }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Retour
        </a>

        <h2>Choisissez votre abonnement</h2>

        @php
            $offres = [
                [
                    'label' => '100 F',
                    'desc' => 'Lire 3 contenus',
                    'duration' => '1 fois',
                    'code' => '100f',
                    'icon' => 'fa-book-open',
                    'color' => 'orange',
                ],
                [
                    'label' => '500 F',
                    'desc' => 'Accès total pendant 3 jours',
                    'duration' => '3 jours',
                    'code' => '500f',
                    'icon' => 'fa-calendar-day',
                    'color' => 'blue',
                ],
                [
                    'label' => '1000 F',
                    'desc' => 'Accès total pendant 1 semaine',
                    'duration' => '7 jours',
                    'code' => '1000f',
                    'icon' => 'fa-calendar-week',
                    'color' => 'green',
                ],
                [
                    'label' => '2500 F',
                    'desc' => 'Accès total pendant 1 mois',
                    'duration' => '30 jours',
                    'code' => '2500f',
                    'icon' => 'fa-calendar-alt',
                    'color' => 'orange',
                ],
            ];
        @endphp

        @foreach ($offres as $index => $offre)
            <form method="POST" action="{{ route('front.abonnement.payer') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $id }}">
                <input type="hidden" name="offre" value="{{ $offre['code'] }}">

                <button type="submit" class="subscription-card card-offset-{{ $index + 1 }}">

                    <div class="price">
                        <i class="fas {{ $offre['icon'] }} icon-{{ $offre['color'] }}"></i>
                        {{ $offre['label'] }}
                    </div>

                    <div class="subscription-description">
                        {{ $offre['desc'] }}
                    </div>

                    <div class="duration-badge badge-{{ $offre['color'] }}">
                        {{ $offre['duration'] }}
                    </div>
                </button>
            </form>
        @endforeach

    </div>

</body>

</html>
