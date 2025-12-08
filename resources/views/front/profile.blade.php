{{-- resources/views/admin/profile.blade.php --}}
@extends('layouts.admin')

@section('content')
<style>
:root {
    --primary-color: #4FB0FF;
    --secondary-color: #FF9933;
    --green-color: #3CCF4E;
    --bg-card: #ffffff;
    --text-color: #333;
    --shadow-color: rgba(0, 0, 0, 0.08);
    --radius: 14px;
    --bg-main: #f5f7fa;
}

body {
    background-color: var(--bg-main);
}

/* Carte profil */
.profile-card {
    max-width: 900px;
    margin: 0 auto;
    background: var(--bg-card);
    border-radius: var(--radius);
    box-shadow: 0 6px 18px var(--shadow-color);
    padding: 30px;
    display: flex;
    gap: 40px;
    flex-wrap: wrap;
}

.profile-photo {
    flex: 0 0 180px;
    border-radius: 14px;
    overflow: hidden;
}

.profile-photo img {
    width: 100%;
    height: auto;
    display: block;
}

.profile-info {
    flex: 1 1 auto;
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.profile-info h2 {
    margin: 0;
    color: var(--primary-color);
    font-weight: 700;
}

.profile-info p {
    margin: 0;
    font-size: 0.95rem;
    color: var(--text-color);
}

.edit-form input {
    width: 100%;
    padding: 10px 14px;
    margin-top: 6px;
    margin-bottom: 12px;
    border-radius: var(--radius);
    border: 1px solid #ccc;
}

.edit-form button {
    background: var(--secondary-color);
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: var(--radius);
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
}

.edit-form button:hover {
    background: #ff8c00;
}

.logout-btn {
    margin-top: 20px;
    background: #e74c3c;
}

.logout-btn:hover {
    background: #c0392b;
}

@media(max-width:768px){
    .profile-card {
        flex-direction: column;
        align-items: center;
    }
    .profile-photo {
        flex: 0 0 200px;
    }
    .profile-info {
        width: 100%;
    }
}
</style>

<div class="container mt-4">
    <div class="profile-card">
        <div class="profile-photo">
            <img src="{{ Auth::user()->photo ? asset('storage/' . Auth::user()->photo) : asset('adminlte/img/default.png') }}" alt="Photo de profil">
        </div>
        <div class="profile-info">
            <h2>{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</h2>
            <p><strong>Rôle :</strong> {{ Auth::user()->role->nom ?? 'Non défini' }}</p>
            <p><strong>Langue :</strong> {{ Auth::user()->langue->nom ?? 'Non défini' }}</p>
            <p><strong>Date d'inscription :</strong> {{ Auth::user()->created_at->format('d/m/Y') }}</p>

            <form id="editProfileForm" class="edit-form">
                @csrf
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" value="{{ Auth::user()->email }}" required>

                <label for="telephone">Téléphone :</label>
                <input type="text" id="telephone" name="telephone" value="{{ Auth::user()->telephone }}" required>

                <button type="submit">Mettre à jour</button>
            </form>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-btn btn mt-2">Déconnexion</button>
            </form>

            <div id="updateMessage" style="margin-top:10px;"></div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#editProfileForm').submit(function(e){
        e.preventDefault();
        let email = $('#email').val();
        let telephone = $('#telephone').val();
        let token = $('input[name="_token"]').val();

        $.ajax({
            url: "{{ route('profile.update') }}",
            type: "POST",
            data: {
                _token: token,
                email: email,
                telephone: telephone
            },
            success: function(response){
                $('#updateMessage').html('<div class="alert alert-success">'+response.message+'</div>');
            },
            error: function(xhr){
                let err = xhr.responseJSON?.message || "Erreur lors de la mise à jour";
                $('#updateMessage').html('<div class="alert alert-danger">'+err+'</div>');
            }
        });
    });
});
</script>
