@extends('layouts.admin')
@section('title')
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Ajouter une langue</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Langues</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card shadow-sm p-4 mb-4 d-flex flex-column justify-content-between"
     style="border-radius:12px; background-color: transparent; min-height:70vh; border: none;">

    <form method="POST" action="{{ route('langues.update', $langue->id) }}">
        @csrf
        @method('PUT')

        <div class="row mb-5">
            <label for="codeLangue" class="col-sm-2 col-form-label" style="font-size: 20px;">Code</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="codeLangue" value="{{ old('codeLangue', $langue->codeLangue) }}" required>
            </div>
        </div>

        <div class="row mb-5">
            <label for="nom" class="col-sm-2 col-form-label" style="font-size: 20px;">Nom</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nom" value="{{ old('nom', $langue->nom) }}" required>
            </div>
        </div>

        <div class="row mb-5">
            <label for="description" class="col-sm-2 col-form-label" style="font-size: 20px;">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control" name="description">{{ old('description', $langue->description) }}</textarea>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('langues.index') }}" class="btn btn-secondary">
                Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
