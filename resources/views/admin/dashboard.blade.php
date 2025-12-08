{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('content')
    <style>
        :root {
            --primary-color: #4FB0FF;
            --secondary-color: #FF9933;
            /* Orange plus vif mais doux */
            --green-color: #3CCF4E;
            /* Vert moderne */
            --blue-soft: #78C4FF;
            /* Bleu doux */
            --bg-card: #ffffff;
            --text-color: #333;
            --shadow-color: rgba(0, 0, 0, 0.08);
            --bg-main: #f5f7fa;
        }

        body {
            background-color: var(--bg-main);
        }

        /* --- Stat Cards --- */
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 22px;
        }

        .card-stat {
            background: var(--bg-card);
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 4px 16px var(--shadow-color);
            border-left: 4px solid var(--secondary-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: .25s ease;
        }

        .card-stat:hover {
            transform: translateY(-6px);
        }

        .card-stat .icon {
            font-size: 2.8rem;
            color: var(--secondary-color);
        }

        .card-stat .value {
            font-size: 2rem;
            font-weight: bold;
            color: var(--secondary-color);
        }

        /* --- Chart cards --- */
        .chart-container {
            background: var(--bg-card);
            padding: 22px;
            border-radius: 14px;
            box-shadow: 0 4px 14px var(--shadow-color);
        }

        .chart-title {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--text-color);
            margin-bottom: 12px;
        }
    </style>

    <div class="container-fluid mt-4">
        <h2 class="mb-4">Tableau de bord administrateur</h2>

        {{-- Statistiques principales --}}
        <div class="dashboard-grid mb-4">
            <div class="card-stat">
                <div>
                    <div>Utilisateurs</div>
                    <div class="value">{{ $usersCount }}</div>
                </div>
                <i class="fas fa-users icon"></i>
            </div>

            <div class="card-stat">
                <div>
                    <div>Médias</div>
                    <div class="value">{{ $mediaCount }}</div>
                </div>
                <i class="fas fa-photo-video icon"></i>
            </div>

            <div class="card-stat">
                <div>
                    <div>Contenus</div>
                    <div class="value">{{ $contentsCount }}</div>
                </div>
                <i class="fas fa-file-alt icon"></i>
            </div>
        </div>

        {{-- Graphiques --}}
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="chart-container">
                    <h5 class="chart-title">Évolution des utilisateurs</h5>
                    <canvas id="usersChart"></canvas>
                </div>
            </div>

            <div class="col-md-6">
                <div class="chart-container">
                    <h5 class="chart-title">Répartition des contenus</h5>
                    <canvas id="donutChart"></canvas>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-12">
                <div class="chart-container">
                    <h5 class="chart-title">Répartition des médias</h5>
                    <canvas id="mediaChart"></canvas>
                </div>
            </div>
        </div>



    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Récupération des couleurs CSS
        const rootStyles = getComputedStyle(document.documentElement);
        const primary = rootStyles.getPropertyValue('--primary-color').trim();
        const secondary = rootStyles.getPropertyValue('--secondary-color').trim();
        const green = rootStyles.getPropertyValue('--green-color').trim();
        const blueSoft = rootStyles.getPropertyValue('--blue-soft').trim();

        /* --- Graphique Utilisateurs (Line) --- */
        new Chart(document.getElementById('usersChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin'],
                datasets: [{
                    label: 'Nouveaux utilisateurs',
                    data: [12, 19, 15, 25, 22, 30],
                    borderColor: primary,
                    backgroundColor: primary + "40", // transparence
                    borderWidth: 2,
                    tension: 0.35
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        /* --- Graphique Donut (Répartition Contenus) --- */
        /* --- Graphique Donut (Répartition Contenus) --- */
        new Chart(document.getElementById('donutChart'), {
            type: 'doughnut',
            data: {
                labels: ['Articles', 'Photos', 'Vidéos', 'Audios'],
                datasets: [{
                    data: [35, 25, 20, 10],
                    backgroundColor: [
                        secondary, // Articles → orange
                        primary, // Photos → bleu
                        green, // Vidéos → vert
                        "#FFA8C2" // Audios → rose pastel doux (nouvelle couleur)
                    ],
                    borderWidth: 2,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                cutout: '60%',
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });


        /* --- Graphique Médias (Barres) --- */
        new Chart(document.getElementById('mediaChart'), {
            type: 'bar',
            data: {
                labels: ['Photos', 'Vidéos', 'Audios'],
                datasets: [{
                    label: 'Nombre de médias',
                    data: [20, 30, 25],
                    backgroundColor: [
                        primary, // Photos → bleu
                        green, // Vidéos → vert
                        secondary // Audios → orange
                    ],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
@endsection
