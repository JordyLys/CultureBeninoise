@extends('layouts.front')

@section('title')
<div class="row align-items-center mb-3">
    <div class="col-sm-6">
        <h3 class="fw-bold text-primary">🌍 Liste des Langues</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#" class="text-secondary fw-semibold">Langues</a></li>
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
    <a href="{{ route('langues.create') }}" class="btn btn-primary btn-lg px-4 beautiful-btn">
        <i class="bi bi-plus-circle"></i> Nouvelle langue
    </a>
</div>

<table id="languesTable" class="table table-hover shadow-sm modern-table" style="width:100%;">
    <thead class="table-header">
        <tr>
            <th>Code</th>
            <th>Nom</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($langues as $langue)
        <tr>
            <td>{{ $langue->codeLangue }}</td>
            <td>{{ $langue->nom }}</td>
            <td class="text-center">
                <a href="#" data-id="{{ $langue->id }}" class="btn btn-sm btn-primary me-1 btn-view">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('langues.edit', $langue->id) }}" class="btn btn-sm btn-warning me-1">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('langues.destroy', $langue->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Voulez-vous vraiment supprimer cette langue ?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal Bootstrap SHOW -->
<div class="modal fade" id="langueModal" tabindex="-1" aria-labelledby="langueModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content shadow-lg border-0 rounded-4">
            <div class="modal-header rounded-top-4">
                <h5 class="modal-title fw-bold" id="langueModalLabel">Détails de la langue</h5>
                <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Fermer"></button>
            </div>
            <div class="modal-body p-4">
                <p><strong>Code :</strong> <span id="modalCode"></span></p>
                <p><strong>Nom :</strong> <span id="modalNom"></span></p>
                <p><strong>Description :</strong> <span id="modalDescription"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>


<script>
$(document).on('click', '.btn-view', function(e) {
    e.preventDefault();
    let id = $(this).data('id');

    $.ajax({
        url: "{{ url('admin/langues') }}/" + id,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            $('#modalCode').text(data.code ?? '-');
            $('#modalNom').text(data.nom ?? '-');
            $('#modalDescription').text(data.description ?? '-');
            new bootstrap.Modal(document.getElementById('langueModal')).show();
        },
        error: function(xhr) {
            alert("Erreur lors du chargement des données.");
            console.log(xhr.responseText);
        }
    });
});
</script>
@endsection




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


/* ───────── BOUTON "NOUVELLE LANGUE" ───────── */
.beautiful-btn {
    background-color: var(--secondary-color);
    color: #fff;
    border: none;
    border-radius: var(--radius);
    font-weight: 600;
    padding: 10px 20px;
    transition: 0.3s ease;
}

.beautiful-btn:hover {
    background-color: #ff8c00;
    transform: translateY(-2px);
}


</style>
