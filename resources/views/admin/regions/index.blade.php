@extends('layouts.admin')

@section('title')
<div class="row align-items-center mb-3">
    <div class="col-sm-6">
        <h3 class="fw-bold text-primary">📍 Liste des Régions</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#" class="text-secondary fw-semibold">Régions</a></li>
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
    <a href="{{ route('regions.create') }}" class="btn btn-primary btn-lg px-4 beautiful-btn">
        <i class="bi bi-plus-circle"></i> Nouvelle région
    </a>
</div>

<table id="regionsTable" class="table table-hover shadow-sm modern-table" style="width:100%;">
    <thead class="table-header">
        <tr>
            <th>Nom</th>
            <th>Localisation</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($regions as $region)
        <tr>
            <td>{{ $region->nom }}</td>
            <td>{{ $region->localisation }}</td>
            <td class="text-center">
                <a href="#" data-id="{{ $region->id }}" class="btn btn-sm btn-primary me-1 btn-view"><i class="bi bi-eye"></i></a>
                <a href="{{ route('regions.edit', $region->id) }}" class="btn btn-sm btn-warning me-1"><i class="bi bi-pencil"></i></a>
                <form action="{{ route('regions.destroy', $region->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer cette région ?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Bootstrap -->
<div class="modal fade" id="regionModal" tabindex="-1" aria-labelledby="regionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-header rounded-top-4">
                <h5 class="modal-title fw-bold" id="regionModalLabel">Détails de la région</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4">
                <p><strong>Nom :</strong> <span id="modalNom"></span></p>
                <p><strong>Description :</strong> <span id="modalDescription"></span></p>
                <p><strong>Localisation :</strong> <span id="modalLocalisation"></span></p>
                <p><strong>Population :</strong> <span id="modalPopulation"></span></p>
                <p><strong>Superficie :</strong> <span id="modalSuperficie"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $('.btn-view').click(function(e) {
        e.preventDefault();
        var id = $(this).data('id');

        $.ajax({
            url: "{{ url('admin/regions') }}/" + id,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#modalNom').text(data.nom ?? '-');
                $('#modalDescription').text(data.description ?? '-');
                $('#modalLocalisation').text(data.localisation ?? '-');
                $('#modalPopulation').text(data.population ?? '-');
                $('#modalSuperficie').text(data.superficie ?? '-');

                new bootstrap.Modal(document.getElementById('regionModal')).show();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX error', textStatus, errorThrown);
                alert('Erreur lors du chargement des données. Voir console (F12) pour détails.');
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

/* ───────── BOUTON "NOUVELLE RÉGION" ───────── */
.beautiful-btn {
    border: none;
    border-radius: var(--radius);
    font-weight: 600;
    padding: 10px 20px;
    transition: 0.3s ease;
}
</style>
@endsection
