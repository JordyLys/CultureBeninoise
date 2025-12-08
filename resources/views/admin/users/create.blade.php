@extends('layouts.admin')

@section('title')
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Ajouter un utilisateur</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Utilisateurs</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
<div class="card shadow-sm p-4 mb-4 d-flex flex-column justify-content-between"
     style="border-radius:12px; background-color: transparent; min-height:70vh; border: none;">

    <form method="POST" action="{{ route('users.store') }}" enctype="multipart/form-data">
        @csrf

        {{-- NOM --}}
        <div class="row mb-5">
            <label for="nom" class="col-sm-2 col-form-label" style="font-size:20px;">Nom</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="nom" value="{{ old('nom') }}" required>
                @error('nom') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- PRENOM --}}
        <div class="row mb-5">
            <label for="prenom" class="col-sm-2 col-form-label" style="font-size:20px;">Prénom</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="prenom" value="{{ old('prenom') }}">
                @error('prenom') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- EMAIL --}}
        <div class="row mb-5">
            <label for="email" class="col-sm-2 col-form-label" style="font-size:20px;">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- MOT DE PASSE --}}
        <div class="row mb-5">
            <label for="password" class="col-sm-2 col-form-label" style="font-size:20px;">Mot de passe</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password" required>
                @error('password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- SEXE --}}
        <div class="row mb-5">
            <label class="col-sm-2 col-form-label" style="font-size:20px;">Sexe</label>
            <div class="col-sm-10">
                <select name="sexe" class="form-control" required>
                    <option value="">Sélectionner...</option>
                    <option value="M" {{ old('sexe') == 'M' ? 'selected' : '' }}>Masculin</option>
                    <option value="F" {{ old('sexe') == 'F' ? 'selected' : '' }}>Féminin</option>

                </select>
                @error('sexe') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- DATE DE NAISSANCE --}}
        <div class="row mb-5">
            <label for="dateNaissance" class="col-sm-2 col-form-label" style="font-size:20px;">Date de naissance</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" name="dateNaissance" value="{{ old('dateNaissance') }}">
                @error('dateNaissance') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ROLE --}}
        <div class="row mb-5">
            <label for="idRole" class="col-sm-2 col-form-label" style="font-size:20px;">Rôle</label>
            <div class="col-sm-10">
                <select class="form-control" name="idRole" required>
                    <option value="">Sélectionner...</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('idRole') == $role->id ? 'selected' : '' }}>{{ $role->nom }}</option>
                    @endforeach
                </select>
                @error('idRole') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- LANGUE --}}
        <div class="row mb-5">
            <label for="idLangue" class="col-sm-2 col-form-label" style="font-size:20px;">Langue</label>
            <div class="col-sm-10">
                <select class="form-control" name="idLangue" required>
                    <option value="">Sélectionner...</option>
                    @foreach($langues as $langue)
                        <option value="{{ $langue->id }}" {{ old('idLangue') == $langue->id ? 'selected' : '' }}>{{ $langue->nom }}</option>
                    @endforeach
                </select>
                @error('idLangue') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- PHOTO --}}
        <div class="row mb-5">
            <label for="photo" class="col-sm-2 col-form-label" style="font-size:20px;">Photo </label>
            <div class="col-sm-10">
                <input type="file" class="form-control" name="photo" accept="image/*,.pdf,.doc,.docx">
                @error('photo') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </div>

    </form>
</div>
@endsection
