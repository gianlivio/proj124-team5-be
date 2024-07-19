@extends('layouts.admin')

@section('content')
    <div class="container">


        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="ms-table-container mt-5">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="fw-bold">Appartamenti</h1>

                <div class="d-flex flex-column">
                    <a href="{{ route('admin.apartments.create') }}" class="btn btn-primary fw-bold">Aggiungi</a>
                    <span class="fw-bold">Attuali: {{ count($apartments) }}</span>
                </div>
            </div>
            <hr>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titolo</th>
                        <th scope="col">Stanze</th>
                        <th scope="col">Letti</th>
                        <th scope="col">Bagni</th>
                        <th scope="col">Metri Quadrati</th>
                        <th scope="col">Disponibile</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($apartments as $curApartment)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ $curApartment->title }}</td>
                            <td>{{ $curApartment->rooms }}</td>
                            <td>{{ $curApartment->beds }}</td>
                            <td>{{ $curApartment->bathroom }}</td>
                            <td>{{ $curApartment->square_mt }}</td>
                            <td>{{ $curApartment->available ? 'si' : 'no' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.apartments.show', ['apartment' => $curApartment->slug]) }}"
                                        class="btn btn-success fw-bold text-light">Dettagli</a>
                                    <a href="{{ route('admin.apartments.edit', ['apartment' => $curApartment->slug]) }}"
                                        class="btn btn-primary fw-bold text-light">Modifica</a>
                                    <button type="button" class="btn fw-bold btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#confirmModal"
                                        data-action="{{ route('admin.apartments.destroy', ['apartment' => $curApartment->slug]) }}">Elimina</button>
                                    <a href="{{ route('admin.apartments.list_sponsor', ['apartment' => $curApartment->slug]) }}"
                                        class="btn btn-warning fw-bold text-light"><i class="fa-solid fa-crown"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Confirm Deletion Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Conferma Eliminazione</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Sei sicuro di voler eliminare questo appartamento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Elimina</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
