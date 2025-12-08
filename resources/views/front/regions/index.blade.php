@extends('layout')
@section('title')
    <div class="row">
        <div class="col-sm-6">
            <h3 class="mb-0">Liste des regions</h3>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-end">
                <li class="breadcrumb-item"><a href="#" class="text-theme">Regions</a></li>
                <li class="breadcrumb-item active text-theme" aria-current="page">Index</li>
            </ol>
        </div>
    </div>
@endsection

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

@section('content')
     <div class="btn-container">
        <a href="{{ route('regions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus"></i> Nouveau
        </a>
    </div>
    <table id="regionsTable" class="table table-striped table-hover table-bordered dataTable"
        style="width:100%; border-radius:12px; overflow:hidden; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <thead class="table-primary">
            <tr>
                <th style="border-top-left;">Nom</th>
                <th>Localisation</th>
                <th style="border-top-right;">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($regions as $region)
                <tr>
                    <td> {{ $region->nom }}</td>
                    <td> {{ $region->localisation }}</td>
                    <td>
                        <a href="#" data-id="{{ $region->id }}" class="btn btn-sm btn-primary btn-view"><i
                                class="bi bi-eye"></i></a>
                        <a href="{{ route('regions.edit', $region->id) }}" class="btn btn-sm btn-warning"><i
                                class="bi bi-pencil"></i></a>
                        <form action="{{ route('regions.destroy', $region->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Voulez-vous vraiment supprimer cette region ?')"><i
                                    class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach

        </tbody>
    </table>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="regionModal" tabindex="-1" aria-labelledby="regionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="margin-top: 70px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="regionModalLabel">Détails de la région</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Nom :</strong> <span id="modalNom"></span></p>
                    <p><strong>Description :</strong> <span id="modalDescription"></span></p>
                    <p><strong>Localisation :</strong> <span id="modalLocalisation"></span></p>
                    <p><strong>population :</strong> <span id="modalpopulation"></span></p>
                    <p><strong>Superficie :</strong> <span id="modalSuperficie"></span></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
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
                        $('#modalNom').text(data.nom);
                        $('#modalDescription').text(data.description);
                        $('#modalLocalisation').text(data.localisation);
                        $('#modalPopulation').text(data.population);
                        $('#modalSuperficie').text(data.superfivie);
                        var modal = new bootstrap.Modal(document.getElementById('regionModal'));
                        modal.show();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error', textStatus, errorThrown);
                        console.error('status', jqXHR.status);
                        console.error('responseText', jqXHR.responseText);
                        alert(
                            'Erreur lors du chargement des données. Voir console (F12) pour détails.');
                    }
                });

            });
        });
    </script>
@endsection
