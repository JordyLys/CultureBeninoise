@extends('layouts.admin')

@section('title')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Modifier un commentaire</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Commentaires</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card shadow-sm p-4 mb-4 d-flex flex-column justify-content-between"
        style="border-radius:12px; background-color: transparent; min-height:50vh; border: none;">

        <form method="POST" action="{{ route('commentaires.update', $commentaire->id) }}">
            @csrf
            @method('PUT')

            {{-- TEXTE --}}
            <div class="row mb-5">
                <label for="texte" class="col-sm-2 col-form-label" style="font-size:20px;">Texte</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="texte" required>{{ old('texte', $commentaire->texte) }}</textarea>
                    @error('texte')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- NOTE --}}
            <div class="row mb-5">
                <label for="note" class="col-sm-2 col-form-label" style="font-size:20px;">Note</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="note" min="0" max="5"
                           value="{{ old('note', $commentaire->note) }}" required>
                    @error('note')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- UTILISATEUR --}}
            <div class="row mb-5">
                <label for="idUsers" class="col-sm-2 col-form-label" style="font-size:20px;">Utilisateur</label>
                <div class="col-sm-10">
                    <select class="form-control" name="idUsers" required>
                        <option value="">Sélectionner...</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('idUsers', $commentaire->idUsers) == $user->id ? 'selected' : '' }}>
                                {{ $user->nom }} {{ $user->prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('idUsers')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- CONTENU --}}
            <div class="row mb-5">
                <label for="idContenu" class="col-sm-2 col-form-label" style="font-size:20px;">Contenu associé</label>
                <div class="col-sm-10">
                    <select class="form-control" name="idContenu" required>
                        <option value="">Sélectionner...</option>
                        @foreach ($contenus as $contenu)
                            <option value="{{ $contenu->id }}"
                                {{ old('idContenu', $commentaire->idContenu) == $contenu->id ? 'selected' : '' }}>
                                {{ $contenu->titre }}
                            </option>
                        @endforeach
                    </select>
                    @error('idContenu')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('commentaires.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>

        </form>
    </div>
@endsection
