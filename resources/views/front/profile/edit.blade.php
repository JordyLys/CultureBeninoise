@extends('layouts.admin')

@section('content')

<style>
:root {
    --primary-color: #4FB0FF;
    --secondary-color: #FF9933;
    --green-color: #3CCF4E;
    --blue-soft: #78C4FF;
    --bg-card: #ffffff;
    --text-color: #333;
    --shadow-color: rgba(0, 0, 0, 0.1);
    --bg-main: #f5f7fa;
}

/* PAGE */
.profile-page {
    padding: 40px 30px;
    background: var(--bg-main);
    min-height: 100vh;
    font-family: 'Poppins', sans-serif;
}

/* HEADER */
.profile-header {
    background: var(--bg-card);
    border-radius: 16px;
    padding: 30px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 20px 40px var(--shadow-color);
    flex-wrap: wrap;
}

.header-left {
    display: flex;
    align-items: center;
    gap: 25px;
}

/* Cercle photo */


.avatar-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
    border: 4px solid var(--secondary-color);
    transition: transform 0.3s, box-shadow 0.3s;
}

.avatar-wrapper img:hover {
    transform: scale(1.08);
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
}
.avatar-wrapper {
    position: relative;
    width: 150px;
    height: 150px;
    border-radius: 50%;
    overflow: visible; /* <- changer de hidden à visible */
    flex-shrink: 0;
    cursor: pointer;
}

.avatar-action {
    position: absolute;
    bottom: 15px;  /* en dessous du cercle */
    right: -15px;   /* légèrement à droite */
    background: var(--secondary-color);
    color: #fff;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-weight: bold;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    transition: all 0.3s;
    z-index: 10;
}
.avatar-action:hover {
    background: var(--blue-soft);
    transform: scale(1.1);
}

.photo-menu {
    position: absolute;
    top: 110%;
    left: 0;
    background: var(--bg-card);
    border-radius: 12px;
    box-shadow: 0 12px 25px rgba(0,0,0,0.2);
    display: none;
    flex-direction: column;
    overflow: hidden;
    z-index: 1000;
}
.photo-menu button {
    display: block;
    width: 100%;
    padding: 12px 18px;
    border: none;
    background: none;
    text-align: left;
    font-weight: 500;
    color: var(--text-color);
    cursor: pointer;
}
.photo-menu button:hover { background: rgba(78, 184, 255, 0.1); }
.photo-menu .danger { color: #ec4899; font-weight: bold; }

.header-info h2 { margin:0; font-weight:700; font-size:1.5rem; color: var(--text-color);}
.header-info p { margin-top:4px; color: #666; font-size:15px; }

/* HEADER RIGHT */
.header-right {
    display: flex;
    align-items: center;
    gap: 15px;
}
.status {
    padding: 6px 16px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 500;
}
.active { background: var(--green-color); color: #fff; }
.inactive { background: #fde2e4; color: #9f1239; }

.btn-primary {
    background: var(--primary-color);
    color: #fff;
    padding: 10px 20px;
    border-radius: 12px;
    border: none;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-primary:hover { background: var(--blue-soft); transform: translateY(-2px); }
.btn-danger {
    background: #ec4899;
    color: #fff;
    padding: 10px 20px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
}
.btn-danger:hover { background: #db2777; transform: translateY(-2px); }

/* BODY */
.profile-body {
    margin-top: 35px;
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 30px;
}

.card {
    background: var(--bg-card);
    border-radius: 16px;
    padding: 28px;
    box-shadow: 0 20px 40px var(--shadow-color);
    transition: transform 0.3s;
}
.card:hover { transform: translateY(-4px); }

.details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px;
}
.details-grid label {
    font-weight: 600;
    color: var(--text-color);
    display:block;
    margin-bottom:3px;
}
.details-grid span { color: var(--text-color); }

/* COMPTE MODIFIER */
.account-card {
    background: var(--bg-card);
    padding: 25px;
    border-radius: 16px;
    box-shadow: 0 15px 30px var(--shadow-color);
    max-width: 450px;
}

.account-card h4 {
    margin-bottom: 20px;
    font-weight: 700;
    font-size: 1.3rem;
}

.account-card input {
    width: 100%;
    padding: 12px;
    margin-bottom: 15px;
    border-radius: 12px;
    border: 1px solid #ccc;
}

.account-card button {
    background: var(--primary-color);
    color: #fff;
    padding: 10px 20px;
    border-radius: 12px;
    border: none;
    cursor: pointer;
}
.account-card button:hover { background: #78C4FF; }
</style>

<div class="profile-page">

    {{-- HEADER --}}
    <div class="profile-header">
        <div class="header-left">
            <div class="avatar-wrapper">
                <img id="userPhoto"
                     src="{{ Auth::user()->photo && file_exists(storage_path('app/public/'.Auth::user()->photo))
                            ? asset('storage/'.Auth::user()->photo)
                            : asset('adminlte/img/default.png') }}"
                     alt="Utilisateur">
                <span class="avatar-action" onclick="togglePhotoMenu()">+</span>

                <div class="photo-menu" id="photoMenu">
                    <form id="uploadPhotoForm" action="{{ route('profile.photo.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="photo" id="photoInput" style="display:none;" onchange="submitPhoto()">
                        <button type="button" onclick="document.getElementById('photoInput').click()">Ajouter</button>
                    </form>
                    <button onclick="deletePhoto()" class="danger">Supprimer</button>
                </div>
            </div>
            <div class="header-info">
                <h2>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h2>
                <p>{{ Auth::user()->role->nom ?? 'Utilisateur' }}</p>
            </div>
        </div>

        <div class="header-right">
            <span class="status {{ Auth::user()->status === 'actif' ? 'active' : 'inactive' }}">
                {{ ucfirst(Auth::user()->status) }}
            </span>
        </div>
    </div>

    {{-- BODY --}}
    <div class="profile-body">
        <div class="card">
            <h4>Détails personnels</h4>
            <div class="details-grid">
                <div><label>Email</label><span>{{ Auth::user()->email }}</span></div>
                <div><label>Sexe</label><span>{{ Auth::user()->sexe ?? '-' }}</span></div>
                <div><label>Date de naissance</label><span>{{ Auth::user()->dateNaissance ? \Carbon\Carbon::parse(Auth::user()->date_naissance)->format('d/m/Y') : '-' }}</span></div>
                <div><label>Membre depuis</label><span>{{ Auth::user()->created_at->format('d/m/Y') }}</span></div>
                <div><label>Langue favorite</label><span>{{ Auth::user()->langue->nom ?? '-' }}</span></div>
                <div><label>Rôle</label><span>{{ Auth::user()->role->nom ?? '-' }}</span></div>
            </div>
        </div>

        {{-- COMPTE MODIFIER --}}
        <div class="account-card">
            <h4>Modifier</h4>
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                <input type="email" name="email" value="{{ Auth::user()->email }}" placeholder="Email" required>
                <input type="password" name="password" placeholder="Nouveau mot de passe (laisser vide pour ne pas changer)">
                <button type="submit">Enregistrer</button>
            </form>
        </div>
    </div>
</div>

<script>
const avatarAction = document.querySelector('.avatar-action'); // <- récupère le bouton +
const photoMenu = document.getElementById('photoMenu');

// Toggle menu au clic sur +
avatarAction.addEventListener('click', (e) => {
    e.stopPropagation(); // empêche de déclencher le clic global
    photoMenu.style.display = photoMenu.style.display === 'flex' ? 'none' : 'flex';
});

// Fermer le menu si clic ailleurs
document.addEventListener('click', (e) => {
    if (!photoMenu.contains(e.target) && e.target !== avatarAction) {
        photoMenu.style.display = 'none';
    }
});

function submitPhoto() { document.getElementById('uploadPhotoForm').submit(); }
function deletePhoto() {
    if(!confirm("Voulez-vous vraiment supprimer cette photo ?")) return;
    fetch('{{ route("profile.photo.delete") }}', { method:'POST', headers:{'X-CSRF-TOKEN':'{{ csrf_token() }}'} })
    .then(res=>res.json()).then(data=>{
        if(data.success){ document.getElementById('userPhoto').src="{{ asset('adminlte/img/default.png') }}"; alert("Photo supprimée"); }
    }).catch(err=>console.error(err));
}
</script>

@endsection
