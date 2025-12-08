@extends('layouts.admin')
@section('title')
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Ajouter une région</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Régions</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card shadow-sm p-4 mb-4 d-flex flex-column justify-content-between"
     style="border-radius:12px; background-color: transparent; min-height:70vh; border: none;">

    <form method="POST" action="{{ route('regions.store') }}">
        @csrf

        <div class="row mb-5">
            <label for="nom" class="col-sm-2 col-form-label " style="font-size: 20px;">Nom</label>
            <div class="col-sm-10">
                <input type="text" class="form-control " name="nom" required>
            </div>
        </div>

        <div class="row mb-5">
            <label for="description" class="col-sm-2 col-form-label " style="font-size: 20px;">Description</label>
            <div class="col-sm-10">
                <textarea class="form-control " name="description" ></textarea>
            </div>
        </div>

         <div class="row mb-5">
            <label for="localisation" class="col-sm-2 col-form-label " style="font-size: 20px;">Localisation</label>
            <div class="col-sm-10">
                <input type="text" class="form-control " name="localisation"  required>
            </div>
        </div>

         <div class="row mb-5">
            <label for="population" class="col-sm-2 col-form-label " style="font-size: 20px;">Population</label>
            <div class="col-sm-10">
                <input type="text" class="form-control " name="population"  required>
            </div>
        </div>

         <div class="row mb-5">
            <label for="superficie" class="col-sm-2 col-form-label " style="font-size: 20px;">Superficie</label>
            <div class="col-sm-10">
                <input type="text" class="form-control " name="superficie"  required>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('regions.index') }}" class="btn btn-secondary">
                Annuler
            </a>
            <button type="submit" class="btn btn-primary">
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection
