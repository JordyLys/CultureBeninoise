@extends('layouts.admin')

@section('title')
<div class="row align-items-center mb-3">
    <div class="col-sm-6">
        <h3 class="fw-bold text-primary">📝 Liste des Contenus</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#" class="text-secondary fw-semibold">Contenus</a></li>
            <li class="breadcrumb-item active text-secondary fw-semibold" aria-current="page">Index</li>
        </ol>
    </div>
</div>
@endsection

@section('content')
<div class="mb-4">
    <a href="{{ route('contenus.create') }}" class="btn btn-primary btn-lg px-4 beautiful-btn">
        <i class="bi bi-plus-circle"></i> Nouveau contenu
    </a>
</div>

<table id="contenusTable" class="table table-hover shadow-sm modern-table" style="width:100%;">
    <thead class="table-header">
        <tr>
            <th>Titre</th>
            <th class="text-center">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach($contenus as $contenu)
        <tr>
            <td>{{ $contenu->titre }}</td>
            <td class="text-center">
                <a href="{{route('front.contenu.show', $contenu->id)}}"  class="btn btn-sm btn-primary me-1 btn-view">
                    <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('contenus.edit', $contenu->id) }}" class="btn btn-sm btn-warning me-1">
                    <i class="bi bi-pencil"></i>
                </a>
                <form action="{{ route('contenus.destroy', $contenu->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"
                        onclick="return confirm('Voulez-vous vraiment supprimer ce contenu ?')">
                        <i class="bi bi-trash"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>


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

    border: none;
    border-radius: var(--radius);
    font-weight: 600;
    padding: 10px 20px;
    transition: 0.3s ease;
}



</style>

@endsection
