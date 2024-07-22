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
                    <span class="fw-bold">Appartamenti mostrati: {{ count($apartments) }}</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-3" id="apartment_list_index">
                <table class="w-100">
                    <thead>
                        <tr>
                            <th class="ps-3 rounded-start-3 ">Titolo</th>
                            <th>stanze</th>
                            <th>letti</th>
                            <th>bagni</th>
                            <th>mq</th>
                            <th>stato</th>
                            <th class="pe-3 text-end rounded-end-3">azioni</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apartments as $curApartment)
                            <tr>
                                <td class="pl-3">
                                    <div class="d-flex align-items-center">

                                        <img class="img-fluid"
                                            src="https://salonlfc.com/wp-content/uploads/2018/01/image-not-found-1-scaled.png"
                                            alt="{{ $curApartment->title }}">
                                        <div class="ps-4">
                                            <p class="fw-medium m-0">{{ $curApartment->title }}</p>
                                            <p class="muted m-0">Address</p>
                                            <p class="fw-bold m-0">125€</p>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $curApartment->rooms }}</td>
                                <td>{{ $curApartment->beds }}</td>
                                <td>{{ $curApartment->bathroom }}</td>
                                <td>{{ $curApartment->square_mt }}</td>
                                <td>{{ $curApartment->available ? 'si' : 'no' }}</td>
                                <td class="text-end px-3">
                                    <div class="dropdown">
                                        <a  
                                            class="ellipsis-menu"
                                            type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis-vertical"></i>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <li><button class="dropdown-item" type="button">Show</button></li>
                                            <li><button class="dropdown-item" type="button">Edit</button></li>
                                            <li><button class="dropdown-item" type="button">Delete</button>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- <table class="table table-striped">
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
            </table> --}}
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
