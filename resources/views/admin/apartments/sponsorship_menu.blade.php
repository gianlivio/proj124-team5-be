@extends('layouts.admin')

@section('content')
<div class="container mt-5 mb-5">
    <h1 class="text-white fw-bold mt-5 mb-md-0">Seleziona l'appartamento da sponsorizzare</h1>  
    
    @if (session('success'))
        <div id="success-alert" class="alert alert-success mt-2 bg-white text-orange">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 rounded-3 mt-2" id="apartment_list_index">
        <div class="list-group ms-list" >
            @foreach ($apartments as $apartment)
            <div id="sponsor_ap" class="d-flex mb-2 p-3 list-group-item-action align-items-center border rounded shadow-sm" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#{{ $apartment->id }}">
                @if ($apartment->img_path)
                    <img class="img-fluid w-25 rounded d-none d-lg-flex"
                        src="{{ asset('storage/' . $apartment->img_path) }}"
                        alt="{{ $apartment->title }}">
                @else
                    <img class="img-fluid w-25 rounded d-none d-lg-flex"
                        src="https://salonlfc.com/wp-content/uploads/2018/01/image-not-found-1-scaled.png"
                        alt="{{ $apartment->title }}">
                @endif
        
                <div class="ms-3 flex-grow-1">
                    <span class="list-group-item-action d-flex align-items-center" >
                        <a id="sponsorship_link" class="fs-5 text-decoration-none text-dark">
                            {{ $apartment->title }} <br>
                            <small class="text-muted">
                                Stanze: {{ $apartment->rooms }} - Bagni: {{ $apartment->bathroom }} - Letti: {{ $apartment->beds }} - Mq: {{ $apartment->square_mt }}
                            </small>

                            @if ($apartment->sponsorship_end_date)
                                <p class="my-4 fw-bold" style="color: #FE5D26">Ti rimangono {{ $apartment->sponsorship_end_date->diffInHours(Carbon\Carbon::now()) }} ore di sponsorizzazione.</p>
                            @else
                                <p class="my-4 fw-bold" style="color: #FE5D26">Questo appartamento non è sponsorizzato.</p>
                            @endif
                        </a>
                    </span>
                </div>
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
                    </div> {{-- FOOTER --}}
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Chiudi</button>
                        <a href="{{ route('admin.apartment.sponsor', ['slug' => $apartment->slug]) }}" class="btn btn-edit">Conferma</a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let successAlert = document.getElementById('success-alert');
        if (successAlert) {
            setTimeout(function() {
                successAlert.style.opacity = 0;
                setTimeout(function() {
                    successAlert.style.display = 'none';
                }, 600); // Extra timeout to allow fade-out effect
            }, 4000); // Adjust the time as needed
        }
    });
</script>
@endsection
