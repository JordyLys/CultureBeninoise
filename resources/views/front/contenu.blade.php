@extends(Auth::check() ? 'layouts.admin' : 'layouts.front')


@section('content')



    <style>
        :root {
            --background-color: #ffeef0;
            --primary-color: #ff7a00;
            --secondary-color: #198754;
            --text-color: #333;
            --text-muted: #666;
        }

        body {
            background: var(--background-color);
            margin: 0;
            font-family: 'Arial', sans-serif;
        }

        .page-container {
            max-width: 1200px;
            margin: 20px;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 20px;
            font-size: 1.5rem;
            color: var(--primary-color);
            cursor: pointer;
            text-decoration: none;
        }

        .content-row {
            display: flex;
            gap: 30px;
            align-items: flex-start;
        }

        .media-col {
            flex: 1;
        }

        .text-col {
            flex: 1;
        }

        .main-media {
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .badge-type {
            background: var(--primary-color);
        }

        .badge-langue {
            background: var(--secondary-color);
        }

        .badge-region {
            background: #333;
        }

        .badge {
            padding: 8px 12px;
            font-size: 0.9rem;
            color: white;
            border-radius: 6px;
            margin-right: 6px;
            font-weight: 600;
        }

        .star {
            font-size: 30px;
            cursor: pointer;
            color: #ccc;
            transition: 0.2s;
        }

        .star:hover,
        .star.active {
            color: var(--primary-color);
        }

        .comment-box {
            border-radius: 12px;
            padding: 25px;
            background: #fff;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-top: 35px;
        }

        .comment-item {
            border-bottom: 1px solid #eee;
            padding: 12px 0;
            color: var(--text-color);
        }

        .comment-item:last-child {
            border-bottom: none;
        }

        .comment-author {
            font-weight: bold;
            color: var(--primary-color);
        }

        .comment-input {
            border-radius: 10px 0 0 10px;
            border-right: none;
            color: var(--text-color);
            border-color: var(--primary-color);
        }

        .comment-input::placeholder {
            color: var(--text-muted);
        }

        .comment-btn {
            border-radius: 0 10px 10px 0;
            background: var(--primary-color);
            color: white;
            font-weight: bold;
            border: 1px solid var(--primary-color);
        }

        .comment-btn:hover {
            background: #e96f00;
        }
    </style>


    <div class="page-container">
        <!-- Flèche retour -->
        <a href="{{ url()->previous() }}" class="back-btn"><i class="fa fa-arrow-left"></i> Retour</a>

        <!-- Contenu principal en flex -->
        <div class="content-row">

            <!-- Colonne Media + badges + note -->
            <div class="media-col">

    @if ($contenu->media->idTypeMedia == 1)
        <img src="{{ asset($contenu->media->chemin) }}"
             class="card-img-top"
             style="height:450px; object-fit:cover;"
             alt="{{ $contenu->titre }}">
    @elseif ($contenu->media->idTypeMedia == 2)
        <video class="main-media" style="width:100%; height:300px; object-fit:cover;"   controls>

            <source src="{{ asset($contenu->media->chemin) }}" type="video/mp4">
            Votre navigateur ne supporte pas la vidéo.
        </video>

@endif
                <!-- Badges -->
                <div class="mt-2 mb-2">
                    @if (optional($contenu->typeContenu)->nom)
                        <span class="badge badge-type small-badge">{{ $contenu->typeContenu->nom }}</span>
                    @endif
                    @if (optional($contenu->langue)->nom)
                        <span class="badge badge-langue small-badge">{{ $contenu->langue->nom }}</span>
                    @endif
                    @if (optional($contenu->region)->nom)
                        <span class="badge badge-region small-badge">{{ $contenu->region->nom }}</span>
                    @endif
                </div>

                <!-- Note -->
                <div class="mb-3">
                    <h5>Note moyenne : {{ $contenu->moyenne_notes }}/5</h5>
                    <div id="stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fa fa-star star" data-value="{{ $i }}"></i>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Colonne texte -->
            <div class="text-col">
                <h2 style="margin-bottom: 15px;">{{ $contenu->titre }}</h2>
                <p>{{ $contenu->texte }}</p>
            </div>

        </div>

        <!-- Commentaires -->
        <div class="comment-box mt-5">
            <h4 class="mb-3">Commentaires</h4>
            @foreach ($contenu->commentaires as $commentaire)
                <div class="comment-item">
                    <span class="comment-author">{{ $commentaire->user->name }} :</span>
                    {{ $commentaire->texte }}
                </div>
            @endforeach

            @auth
                <form method="POST" action="{{ route('front.commentaire.store', $contenu->id) }}" class="mt-3">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="texte" class="form-control comment-input"
                            placeholder="Écrire un commentaire..." required>
                        <button class="btn comment-btn" type="submit">Envoyer</button>
                    </div>
                </form>
            @else
                <p class="text-muted mt-2">
                    <a href="{{ route('login') }}" style="color:var(--primary-color); font-weight:600;">
                        Connectez-vous
                    </a> pour commenter.
                </p>
            @endauth
        </div>

    </div>

    <style>
        .small-badge {
            padding: 4px 8px;
            font-size: 0.75rem;
            margin-right: 4px;
        }
    </style>


    <script>
        document.querySelectorAll('.star').forEach(star => {
            star.addEventListener('click', function() {
                const note = this.dataset.value;
                document.querySelectorAll('.star').forEach(s => s.classList.remove('active'));
                this.classList.add('active');
                alert("Vous avez mis " + note + " étoiles !");
            });
        });
    </script>

@endsection
