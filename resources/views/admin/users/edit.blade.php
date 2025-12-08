@extends('layouts.admin')

@section('title')
    <div class="row">
        <div class="col-sm-6"><h3 class="mb-0">Modifier un utilisateur</h3></div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Utilisateurs</a></li>
                <li class="breadcrumb-item active">Edit</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')

<div class="card shadow-sm p-4 mb-4"
     style="border-radius:12px; background-color: transparent; min-height:70vh; border: none;">

    <form method="POST" action="{{ route('users.update', $user->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- NOM --}}
        <div class="row mb-5">
            <label class="col-sm-2 col-form-label">Nom</label>
            <div class="col-sm-10">
                <input type="text" class="form-control"
                       name="nom"
                       value="{{ old('nom', $user->nom) }}" required>
                @error('nom') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- PRENOM --}}
        <div class="row mb-5">
            <label class="col-sm-2 col-form-label">Prénom</label>
            <div class="col-sm-10">
                <input type="text" class="form-control"
                       name="prenom"
                       value="{{ old('prenom', $user->prenom) }}">
                @error('prenom') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- EMAIL --}}
        <div class="row mb-5">
            <label class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <input type="email" class="form-control"
                       name="email"
                       value="{{ old('email', $user->email) }}" required>
                @error('email') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- MOT DE PASSE (OPTIONNEL EN EDIT) --}}
        <div class="row mb-5">
            <label class="col-sm-2 col-form-label">Mot de passe</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password">
                <small class="text-muted">Laisser vide pour ne pas changer</small>
                @error('password') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- SEXE --}}
        <div class="row mb-5">
            <label class="col-sm-2 col-form-label">Sexe</label>
            <div class="col-sm-10">
                <select name="sexe" class="form-control" required>
                    <option value="">Sélectionner...</option>
                    <option value="M" {{ old('sexe', $user->sexe) == 'M' ? 'selected' : '' }}>Masculin</option>
                    <option value="F" {{ old('sexe', $user->sexe) == 'F' ? 'selected' : '' }}>Féminin</option>
                    <option value="O" {{ old('sexe', $user->sexe) == 'O' ? 'selected' : '' }}>Autre</option>
                </select>
                @error('sexe') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- DATE DE NAISSANCE --}}
        <div class="row mb-5">
            <label class="col-sm-2 col-form-label">Date de naissance</label>
            <div class="col-sm-10">
                <input type="date" class="form-control"
                       name="dateNaissance"
                       value="{{ old('dateNaissance', $user->dateNaissance) }}">
                @error('dateNaissance') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- ROLE --}}
        <div class="row mb-5">
            <label class="col-sm-2 col-form-label">Rôle</label>
            <div class="col-sm-10">
                <select class="form-control" name="role_id" required>
                    <option value="">Sélectionner...</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}"
                            {{ old('role_id', $user->idRole) == $role->id ? 'selected' : '' }}>
                            {{ $role->nom }}
                        </option>
                    @endforeach
                </select>
                @error('role_id') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- LANGUE --}}
        <div class="row mb-5">
            <label class="col-sm-2 col-form-label">Langue</label>
            <div class="col-sm-10">
                <select class="form-control" name="langue_id" required>
                    <option value="">Sélectionner...</option>
                    @foreach($langues as $langue)
                        <option value="{{ $langue->id }}"
                            {{ old('langue_id', $user->idLangue) == $langue->id ? 'selected' : '' }}>
                            {{ $langue->nom }}
                        </option>
                    @endforeach
                </select>
                @error('langue_id') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        {{-- PHOTO ACTUELLE --}}
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Photo actuelle</label>
            <div class="col-sm-10">
                @if($user->photo)
                    <img src="{{ asset('uploads/users/'.$user->photo) }}"
                         alt="Photo utilisateur"
                         style="height: 100px; border-radius:8px;">
                @else
                    <span class="text-muted">Aucune photo</span>
                @endif
            </div>
        </div>

        {{-- CHANGER PHOTO --}}
        <div class="row mb-5">
            <label class="col-sm-2 col-form-label">Nouvelle photo / document</label>
            <div class="col-sm-10">
                <input type="file" class="form-control"
                       name="photo"
                       accept="image/*,.pdf,.doc,.docx">
                @error('photo') <div class="text-danger mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Annuler</a>
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </div>

    </form>
</div>

@endsection
