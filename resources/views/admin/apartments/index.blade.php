@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="ms-table-container mt-5">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="fw-bold">Appartamenti</h1>

                <div class="d-flex flex-column">
                    <a href="{{ route('admin.apartments.create') }}" class="btn btn-primary fw-bold">Crea nuovo appartamento</a>
                    <span class="fw-bold">Appartamenti mostrati: <?= count($apartments) ?> </span>

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
                            <td>{{ $curApartment->bathrooms }}</td>
                            <td>{{ $curApartment->square_mt }}</td>
                            <td>{{ $curApartment->available ? 'si' : 'no' }}</td>
                            
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.apartments.show', ['apartment' => $curApartment->slug]) }}"
                                        class="btn btn-success fw-bold text-light">Dettagli</a>
                                    <a href="{{ route('admin.apartments.edit', ['apartment' => $curApartment->slug]) }}"
                                        class="btn btn-primary fw-bold text-light">Modifica</a>
                                    <form
                                        action="{{ route('admin.apartments.destroy', ['apartment' => $curApartment->slug]) }}"
                                        method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn fw-bold btn-danger" data-bs-toggle="modal" data-bs-target="#confirmModal" data-action="{{ route('admin.apartments.destroy', ['apartment' => $curApartment->slug]) }}">Elimina</button>
                                        <div class="modal fade" id="confirmModal" tabindex="-1"
                                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Conferma Eliminazione
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Sei sicuro di voler eliminare questo appartamento?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Annulla</button>
                                                        <button type="submit" class="btn btn-danger"
                                                            id="deleteButton">Elimina</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <a href="{{ route('admin.apartments.list_sponsor', ['apartment' => $curApartment->slug]) }}"
                                        class="btn btn-warning fw-bold text-light">
                                        <i class="fa-solid fa-crown"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>
    </div>
@endsection
