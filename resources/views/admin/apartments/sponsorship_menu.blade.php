@extends('layouts.admin')

@section('content')
    <div class="container mt-3" style="background-color: white">
        <h1>Seleziona l'appartamento che vuoi sponsorizzare!</h1>

        @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
        <ul class="list-group">
            <div class="list-group ms-list" style="cursor: pointer">
                @foreach ($apartments as $apartment)
                    <span data-bs-toggle="modal" data-bs-target="#{{ $apartment->id }}">
                        <a class="ms-item list-group-item list-group-item-action mb-2 py-3">{{$apartment->title }}</a>
                    </span> 
    
    
                    <!-- Modale Conferma -->
                    <div class="modal fade" id="{{ $apartment->id }}" tabindex="-1" aria-labelledby="editModal" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                {{-- HEADEAR --}}
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Conferma sponsorizzazione</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                {{-- BODY --}}
                                <div class="modal-body">
                                    <span>Vuoi davvero sponsorizzare <strong><i>{{ $apartment->title }}</i></strong> ?</span>
                                </div>
                                {{-- FOOTER --}}
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Chiudi</button>
                                    <a href="{{ route ("admin.apartment.sponsor", ["slug" => $apartment->slug])}}" class="btn btn-primary">Conferma</a>
                                </div>
                            </div>
                        </div>
                    </div>
        @endforeach
@endsection
