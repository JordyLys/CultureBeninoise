@extends('layouts.admin')
@section('content')

<div class="profile-page">

    {{-- HEADER PROFIL --}}
    <div class="profile-header">
        <div class="header-left">
            <div class="avatar-wrapper">
                <img id="userPhoto"
                     src="{{ Auth::user()->photo ? asset('storage/'.Auth::user()->photo) : asset('images/default-user.png') }}"
                     alt="Utilisateur">

                <span class="avatar-action" onclick="togglePhotoMenu()">+</span>

                <div class="photo-menu" id="photoMenu">

                    <form id="uploadPhotoForm" action="{{ route('profile.photo.upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="photo" id="photoInput" style="display:none;" onchange="submitPhoto()">
                        <button type="button" onclick="document.getElementById('photoInput').click()">Ajouter</button>
                    </form>

                    <button  onclick="deletePhoto()">Supprimer</button>
                </div>
            </div>

            <div class="header-info">
                <h2>{{ Auth::user()->prenom }} {{ Auth::user()->nom }}</h2>
                <p>{{ Auth::user()->role->name ?? 'Utilisateur' }}</p>
            </div>
        </div>

        <div class="header-right">
            <span class="status {{ Auth::user()->status === 'actif' ? 'active' : 'inactive' }}">
                {{ ucfirst(Auth::user()->status) }}
            </span>

            <button class="btn-orange" onclick="openModal('profileModal')">Modifier</button>
        </div>
    </div>

    {{-- CONTENU --}}
    <div class="profile-body">
        {{-- INFOS --}}
        <div class="card">
            <h4>Personal Details</h4>
            <div class="details-grid">
                <div>
                    <label>Email</label>
                    <span>{{ Auth::user()->email }}</span>
                </div>
                <div>
                    <label>Sexe</label>
                    <span>{{ Auth::user()->sexe ?? '-' }}</span>
                </div>
                <div>
                    <label>Date de naissance</label>
                    <span>{{ Auth::user()->date_naissance ? \Carbon\Carbon::parse(Auth::user()->date_naissance)->format('d/m/Y') : '-' }}</span>
                </div>
                <div>
                    <label>Membre depuis</label>
                    <span>{{ Auth::user()->created_at->format('d/m/Y') }}</span>
                </div>
                <div>
                    <label>Langue favorite</label>
                    <span>{{ Auth::user()->langue->nom ?? '-' }}</span>
                </div>
                <div>
                    <label>Rôle</label>
                    <span>{{ Auth::user()->role->name ?? '-' }}</span>
                </div>
            </div>
        </div>

        {{-- COMPTE --}}
        <div class="card side-card">
            <h4>Compte</h4>
            <button class="btn-rose full">Supprimer le compte</button>
        </div>
    </div>
</div>

{{-- MODAL PHOTO --}}
<div class="modal-overlay" id="photoModal">
    <div class="modal">
        <img id="photoModalImg" src="" style="width:100%; border-radius:10px;">
        <button class="btn-orange" onclick="closeModal('photoModal')">Fermer</button>
    </div>
</div>

{{-- MODAL EMAIL --}}
<div class="modal-overlay" id="profileModal">
    <div class="modal">
        <h4>Modifier l’email</h4>
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            <input type="email" name="email" value="{{ Auth::user()->email }}" required>
            <div class="modal-actions">
                <button type="button" onclick="closeModal('profileModal')">Annuler</button>
                <button type="submit" class="btn-orange">Enregistrer</button>
            </div>
        </form>
    </div>
</div>

@endsection

<style>
.profile-page{
    padding:30px;
    background:#f4f6f8;
    min-height:100vh;
}

/* HEADER */
.profile-header{
    background:#fff;
    border-radius:14px;
    padding:25px 30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    box-shadow:0 10px 25px rgba(0,0,0,0.08);
}
.header-left{display:flex; align-items:center; gap:20px;}
.avatar-wrapper{position:relative;}
.avatar-wrapper img{
    width:90px;
    height:90px;
    border-radius:50%;
    object-fit:cover;
    border:2px solid #fde2e4;
}
.avatar-action{
    position:absolute;
    bottom:0;
    right:0;
    background:#f59e0b;
    color:#fff;
    width:26px;
    height:26px;
    border-radius:50%;
    display:flex;
    align-items:center;
    justify-content:center;
    cursor:pointer;
}
.photo-menu{
    position:absolute;
    top:100%;
    left:0;
    background:#fff;
    border-radius:10px;
    box-shadow:0 10px 20px rgba(0,0,0,.15);
    display:none;
    overflow:hidden;
    z-index:1000;
}
.photo-menu button{
    display:block;
    width:100%;
    padding:10px 18px;
    border:none;
    background:none;
    text-align:left;
    cursor:pointer;
}
.photo-menu .danger{color:#ec4899;}
.header-info h2{margin:0;}
.header-info p{margin:4px 0 0; color:#666;}
.header-right{display:flex; align-items:center; gap:15px;}
.status{padding:5px 12px; border-radius:20px; font-size:13px;}
.active{background:#d1fae5;color:#065f46;}
.inactive{background:#fde2e4;color:#9f1239;}

/* BODY */
.profile-body{margin-top:30px; display:grid; grid-template-columns:2fr 1fr; gap:25px;}
.card{background:#fff; border-radius:14px; padding:25px; box-shadow:0 10px 25px rgba(0,0,0,0.08);}
.details-grid{display:grid; grid-template-columns:repeat(2,1fr); gap:20px;}
.details-grid label{font-weight:600; color:#555; display:block;}
.details-grid span{color:#111;}
.side-card{display:flex; flex-direction:column; justify-content:space-between;}
.full{width:100%;}

/* BOUTONS */
.btn-orange{background:#f59e0b; color:#fff; padding:8px 16px; border-radius:8px; border:none;}
.btn-rose{background:#ec4899; color:#fff; padding:12px; border-radius:10px; border:none;}

/* MODAL */
.modal-overlay{
    position:fixed;
    inset:0;
    background:rgba(0,0,0,.4);
    display:none;
    justify-content:center;
    align-items:center;
    z-index:2000;
    opacity:0;
    transition:opacity 0.3s ease;
}
.modal-overlay.show{
    display:flex;
    opacity:1;
}
.modal{background:#fff; padding:20px; border-radius:14px; width:320px; transform:translateY(-20px); transition:transform 0.3s ease;}
.modal-overlay.show .modal{transform:translateY(0);}
</style>

<script>
// Menu photo
function togglePhotoMenu(){
    const menu = document.getElementById('photoMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

// Ouvrir modal
function openModal(id){
    const modal = document.getElementById(id);
    modal.classList.add('show');
}

// Fermer modal
function closeModal(id){
    const modal = document.getElementById(id);
    modal.classList.remove('show');
}

// Voir photo
function viewPhoto(){
    const src = document.getElementById('userPhoto').src;
    document.getElementById('photoModalImg').src = src;
    openModal('photoModal');
}

// Ajouter photo
function submitPhoto(){
    document.getElementById('uploadPhotoForm').submit();
}

// Supprimer photo
function deletePhoto(){
    if(!confirm("Voulez-vous vraiment supprimer cette photo ?")) return;

    fetch('{{ route("profile.photo.delete") }}', {
        method: 'POST',
        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
    })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            document.getElementById('userPhoto').src = "{{ asset('adminlte/img/default.png') }}";
            alert("Photo supprimée");
        }
    })
    .catch(err => console.error(err));
}
</script>
