@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1 class="text-white fw-bold mt-5 mb-md-0">Seleziona l'appartamento da sponsorizzare</h1>  
    
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 rounded-3 mt-2" id="apartment_list_index">
        <div class="list-group ms-list" >
            @foreach ($apartments as $apartment)
            <div class="d-flex mb-2 py-3" style="cursor: pointer">
                @if ($apartment->img_path)
                    <img class="img-fluid w-25"
                        src="{{ asset('storage/' . $apartment->img_path) }}"
                        alt="{{ $apartment->title }}">
                @else
                    <img class="img-fluid w-25"
                        src="https://salonlfc.com/wp-content/uploads/2018/01/image-not-found-1-scaled.png"
                        alt="{{ $apartment->title }}">
                @endif

                <span class="ms-item list-group-item list-group-item-action d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#{{ $apartment->id }}">
                    
                    <a id="sponsorship_link" class="fs-5">{{ $apartment->title }} <br>
                        Stanze: {{ $apartment->rooms}} - Bagni:{{ $apartment->bathroom}} - Letti:{{ $apartment->beds}} - Mq:{{ $apartment->square_mt}} </a>
                </span>
            </div>


        <!-- Modale Conferma -->
        <div class="modal fade" id="{{ $apartment->id }}" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    {{-- HEADEAR --}}
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Conferma sponsorizzazione</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"aria-label="Close"></button>
                    </div>

                    {{-- BODY --}}
                    <div class="modal-body">
                        <span>Vuoi davvero sponsorizzare <strong><i>{{ $apartment->title }}</i></strong>?</span>
                    </div>

                    {{-- FOOTER --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Chiudi</button>
                        <a href="{{ route('admin.apartment.sponsor', ['slug' => $apartment->slug]) }}" class="btn btn-edit">Conferma</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
