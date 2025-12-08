@extends('layouts.admin')

@section('title')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Modifier un contenu</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#">Contenus</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </div>
    </div>
@endsection

@section('content')
    <div class="card shadow-sm p-4 mb-4 d-flex flex-column justify-content-between"
        style="border-radius:12px; background-color: transparent; min-height:70vh; border: none;">

        <form method="POST" action="{{ route('contenus.update', $contenu->id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- TITRE --}}
            <div class="row mb-5">
                <label for="titre" class="col-sm-2 col-form-label" style="font-size:20px;">Titre</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="titre" value="{{ old('titre', $contenu->titre) }}"
                        required>
                    @error('titre')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- TEXTE --}}
            <div class="row mb-5">
                <label for="texte" class="col-sm-2 col-form-label" style="font-size:20px;">Texte</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="texte">{{ old('texte', $contenu->texte) }}</textarea>
                    @error('texte')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- STATUT --}}
            <div class="row mb-5">
                <label for="statut" class="col-sm-2 col-form-label" style="font-size:20px;">Statut</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="statut" value="{{ old('statut', $contenu->statut) }}">
                    @error('statut')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- DATE CREATION --}}
            <div class="row mb-5">
                <label for="dateCreation" class="col-sm-2 col-form-label" style="font-size:20px;">Date de création</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control" name="dateCreation"
                        value="{{ old('dateCreation', $contenu->dateCreation ? $contenu->dateCreation->format('Y-m-d\TH:i') : '') }}">
                    @error('dateCreation')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- DATE VALIDATION --}}
            <div class="row mb-5">
                <label for="dateValidation" class="col-sm-2 col-form-label" style="font-size:20px;">Date de
                    validation</label>
                <div class="col-sm-10">
                    <input type="datetime-local" class="form-control" name="dateValidation"
                        value="{{ old('dateValidation', $contenu->dateValidation ? $contenu->dateValidation->format('Y-m-d\TH:i') : '') }}">
                    @error('dateValidation')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- ID TYPE CONTENU --}}
            <div class="row mb-5">
                <label for="idTypeContenu" class="col-sm-2 col-form-label" style="font-size:20px;">Type de contenu</label>
                <div class="col-sm-10">
                    <select class="form-control" name="idTypeContenu" required>
                        <option value="">Sélectionner un type</option>
                        @foreach ($typesContenu as $type)
                            <option value="{{ $type->id }}"
                                {{ old('idTypeContenu', $contenu->idTypeContenu) == $type->id ? 'selected' : '' }}>
                                {{ $type->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('idTypeContenu')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            {{-- ID PARENT --}}
            <div class="row mb-5">
                <label for="idParent" class="col-sm-2 col-form-label" style="font-size:20px;">Contenu parent</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="idParent"
                        value="{{ old('idParent', $contenu->idParent) }}">
                    @error('idParent')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- ID MODERATEUR --}}
            <div class="row mb-5">
                <label for="idModerateur" class="col-sm-2 col-form-label" style="font-size:20px;">Modérateur</label>
                <div class="col-sm-10">
                    <select class="form-control" name="idModerateur">
                        <option value="">Sélectionner un modérateur</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('idModerateur', $contenu->idModerateur) == $user->id ? 'selected' : '' }}>
                                {{ $user->nom }} {{ $user->prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('idModerateur')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            {{-- ID AUTEUR --}}
            <div class="row mb-5">
                <label for="idAuteur" class="col-sm-2 col-form-label" style="font-size:20px;">Auteur</label>
                <div class="col-sm-10">
                    <select class="form-control" name="idAuteur" required>
                        <option value="">Sélectionner un auteur</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}"
                                {{ old('idAuteur', $contenu->idAuteur) == $user->id ? 'selected' : '' }}>
                                {{ $user->nom }} {{ $user->prenom }}
                            </option>
                        @endforeach
                    </select>
                    @error('idAuteur')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            {{-- ID REGION --}}
            <div class="row mb-5">
                <label for="idRegion" class="col-sm-2 col-form-label" style="font-size:20px;">Région</label>
                <div class="col-sm-10">
                    <select class="form-control" name="idRegion" required>
                        <option value="">Sélectionner une région</option>
                        @foreach ($regions as $region)
                            <option value="{{ $region->id }}"
                                {{ old('idRegion', $contenu->idRegion) == $region->id ? 'selected' : '' }}>
                                {{ $region->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('idRegion')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            {{-- ID LANGUE --}}
            <div class="row mb-5">
                <label for="idLangue" class="col-sm-2 col-form-label" style="font-size:20px;">Langue</label>
                <div class="col-sm-10">
                    <select class="form-control" name="idLangue" required>
                        <option value="">Sélectionner une langue</option>
                        @foreach ($langues as $langue)
                            <option value="{{ $langue->id }}"
                                {{ old('idLangue', $contenu->idLangue) == $langue->id ? 'selected' : '' }}>
                                {{ $langue->nom }}
                            </option>
                        @endforeach
                    </select>
                    @error('idLangue')
                        <div class="text-danger mt-1">{{ $message }}</div>
                    @enderror
                </div>
            </div>




            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('contenus.index') }}" class="btn btn-secondary">Annuler</a>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>

        </form>
    </div>
@endsection
