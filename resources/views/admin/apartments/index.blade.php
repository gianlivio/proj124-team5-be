@extends('layouts.admin')

@section('content')
    <div class="container mb-4">
        @if (session('message'))
            <div class="alert alert-success mt-2 bg-white text-orange">
                {{ session('message') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success mt-2">
                {{ session('success') }}
            </div>
        @endif

        <div class="ms-table-container mt-5">
            <div class="d-flex justify-content-between align-items-center flex-column flex-md-row">
                <h1 class="fw-bold text-white mb-3 mb-md-0">Appartamenti</h1>
                <div class="d-flex flex-column align-items-center">
                    <a href="{{ route('admin.apartments.create') }}" class="btn btn-orange fw-bold mb-2 mb-md-0">Aggiungi</a>
                    <span class="fw-bold text-white">Attuali: {{ count($apartments) }}</span>
                </div>
            </div>

            <div class="bg-white p-4 rounded-3 mt-2" id="apartment_list_index">
                <div class="table-responsive"> <!-- Aggiungere questa classe per rendere la tabella scrollabile su dispositivi mobili -->
                    <table class="table">
                        <thead class="fw-bold">
                            <tr>
                                <th class="ps-3 rounded-start-3">Titolo</th>
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
                                            <a href="{{ route('admin.apartments.show', ['apartment' => $curApartment->slug]) }}">
                                                @if ($curApartment->img_path)
                                                    <img class="img-fluid"
                                                        src="{{ asset('storage/' . $curApartment->img_path) }}"
                                                        alt="{{ $curApartment->title }}">
                                                @else
                                                    <img class="img-fluid"
                                                        src="https://salonlfc.com/wp-content/uploads/2018/01/image-not-found-1-scaled.png"
                                                        alt="{{ $curApartment->title }}">
                                                @endif
                                            </a>
                                            <div class="ps-4">
                                                <p class="fw-medium m-0">
                                                    <a class=""
                                                        href="{{ route('admin.apartments.show', ['apartment' => $curApartment->slug]) }}">{{ $curApartment->title }}</a>
                                                </p>
                                                <p class="muted m-0">Address</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $curApartment->rooms }}</td>
                                    <td>{{ $curApartment->beds }}</td>
                                    <td>{{ $curApartment->bathroom }}</td>
                                    <td>{{ $curApartment->square_mt }}</td>
                                    <td>
                                        {!! $curApartment->available
                                            ? '<p class="my_chips active m-0">Si</p>'
                                            : '<p class="my_chips deactive m-0">No</p>' !!}
                                    </td>
                                    <td class="text-end px-3">
                                        <div class="dropdown">
                                            <a class="ellipsis-menu" type="button" data-bs-toggle="dropdown"
                                                aria-expanded="false">
                                                <i class="fa-solid fa-ellipsis-vertical fs-4"></i>
                                            </a>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" type="button"
                                                        href="{{ route('admin.apartments.show', ['apartment' => $curApartment->slug]) }}">Dettagli</a>
                                                </li>
                                                <li><a class="dropdown-item"
                                                        href="{{ route('admin.apartments.edit', ['apartment' => $curApartment->slug]) }}"
                                                        type="button">Modifica</a></li>
                                                <li>
                                                    <button type="button" class="dropdown-item" data-bs-toggle="modal"
                                                        data-bs-target="#confirmModal"
                                                        data-action="{{ route('admin.apartments.destroy', ['apartment' => $curApartment->slug]) }}">Elimina</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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