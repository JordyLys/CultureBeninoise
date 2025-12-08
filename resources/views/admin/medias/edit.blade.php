@extends('layouts.admin')

@section('title')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Modifier un média</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Médias</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card shadow-sm p-4 mb-4 d-flex flex-column justify-content-between"
        style="border-radius:12px; background-color: transparent; min-height:70vh; border: none;">

        <form method="POST" action="{{ route('medias.update', $media->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- DESCRIPTION --}}
            <div class="row mb-5">
                <label for="description" class="col-sm-2 col-form-label" style="font-size:20px;">Description</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="description" value="{{ old('description', $media->description) }}" required>
                    @error('description')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- CHEMIN --}}
            <div class="row mb-5">
                <label for="chemin" class="col-sm-2 col-form-label" style="font-size:20px;">Fichier</label>
                <div class="col-sm-10">
                    <input type="file" class="form-control" name="chemin">
                    <small class="text-muted">Laissez vide pour conserver le fichier actuel</small>
                    @error('chemin')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- ID TYPE MEDIA --}}
            <div class="row mb-5">
                <label for="idTypeMedia" class="col-sm-2 col-form-label" style="font-size:20px;">Type de média</label>
                <div class="col-sm-10">
                    <select class="form-control" name="idTypeMedia" required>
                        <option value="">Sélectionner un type</option>
                        @foreach ($typesMedia as $type)
                            <option value="{{ $type->id }}" {{ old('idTypeMedia', $media->idTypeMedia) == $type->id ? 'selected' : '' }}>
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('idTypeMedia')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- ID CONTENU --}}
            <div class="row mb-5">
                <label for="idContenu" class="col-sm-2 col-form-label" style="font-size:20px;">Contenu associé</label>
                <div class="col-sm-10">
                    <select class="form-control" name="idContenu" required>
                        <option value="">Sélectionner un contenu</option>
                        @foreach ($contenus as $contenu)
                            <option value="{{ $contenu->id }}" {{ old('idContenu', $media->idContenu) == $contenu->id ? 'selected' : '' }}>
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
                <a href="{{ route('medias.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>

        </form>
    </div>
@endsection
