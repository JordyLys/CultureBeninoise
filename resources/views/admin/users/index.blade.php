@extends('layouts.admin')

@section('title')
<div class="row align-items-center mb-3">
    <div class="col-sm-6">
        <h3 class="fw-bold text-primary">👤 Liste des utilisateurs</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#" class="text-secondary fw-semibold">Utilisateurs</a></li>
            <li class="breadcrumb-item active text-secondary fw-semibold" aria-current="page">Index</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success shadow-sm rounded-3">{{ session('success') }}</div>
@endif
@if(session('error'))
<div class="alert alert-danger shadow-sm rounded-3">{{ session('error') }}</div>
@endif

<div class="mb-4">
    <a href="{{ route('users.create') }}" class="btn btn-primary btn-lg px-4 beautiful-btn">
        <i class="bi bi-plus-circle"></i> Nouvel utilisateur
    </a>
</div>

<table id="usersTable" class="table table-hover shadow-sm modern-table" style="width:100%;">
    <thead class="table-header">
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->nom }}</td>
            <td>{{ $user->prenom }}</td>
            <td class="text-center">
                <a href="#" data-id="{{ $user->id }}" class="btn btn-sm btn-primary me-1 btn-view"><i class="bi bi-eye"></i></a>
                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Bootstrap -->
<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-header rounded-top-4">
                <h5 class="modal-title fw-bold" id="userModalLabel">Détails de l'utilisateur</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4">
                <p><strong>Nom :</strong> <span id="modalNom"></span></p>
                <p><strong>Prénom :</strong> <span id="modalPrenom"></span></p>
                <p><strong>Email :</strong> <span id="modalEmail"></span></p>
                <p><strong>Sexe :</strong> <span id="modalSexe"></span></p>
                <p><strong>Statut :</strong> <span id="modalStatut"></span></p>
                <p><strong>Date de naissance :</strong> <span id="modalDateNaissance"></span></p>
                <p><strong>Date d'inscription :</strong> <span id="modalDateInscription"></span></p>
                <p><strong>Rôle :</strong> <span id="modalRole"></span></p>
                <p><strong>Langue :</strong> <span id="modalLangue"></span></p>
                <div class="mt-3">
                    <strong>Photo :</strong><br>
                    <img id="modalPhoto" src="" alt="Photo utilisateur" style="max-width:150px; border-radius:10px; margin-top:10px;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('.btn-view').click(function(e){
        e.preventDefault();
        let id = $(this).data('id');

        $.ajax({
            url: "{{ url('admin/users') }}/" + id,
            type: 'GET',
            dataType: 'json',
            success: function(data){
                $('#modalNom').text(data.nom);
                $('#modalPrenom').text(data.prenom);
                $('#modalEmail').text(data.email);
                $('#modalSexe').text(data.sexe);
                $('#modalStatut').text(data.statut);
                $('#modalDateNaissance').text(data.dateNaissance);
                $('#modalDateInscription').text(data.dateInscription);
                $('#modalRole').text(data.role);
                $('#modalLangue').text(data.langue);
                $('#modalPhoto').attr('src', data.photo ? basePhotoUrl + data.photo : defaultPhotoUrl);

                new bootstrap.Modal(document.getElementById('userModal')).show();
            },
            error: function(){
                alert("Erreur lors du chargement des données.");
            }
        });
    });
});
</script>

<style>
:root {
    --primary-color: #4FB0FF;
    --secondary-color: #FF9933;
    --success-color: #3CCF4E;
    --bg-card: #ffffff;
    --text-color: #333;
    --radius: 14px;
}

/* ───────── TABLEAU PREMIUM ───────── */
.modern-table {
    border-radius: var(--radius);
    overflow: hidden;
    background: var(--bg-card);
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    border: none;
}

.table-header {
    background: var(--primary-color);
    color: #fff;
    font-weight: 600;
    text-align: center;
    letter-spacing: 0.5px;
}

.modern-table tbody tr {
    transition: all 0.3s ease;
}

.modern-table tbody tr:hover {
    background: var(--secondary-color);
    color: #fff;
}

/* ───────── BOUTON "NOUVEAU UTILISATEUR" ───────── */
.beautiful-btn {

    border: none;
    border-radius: var(--radius);
    font-weight: 600;
    padding: 10px 20px;
    transition: 0.3s ease;
}

</style>
