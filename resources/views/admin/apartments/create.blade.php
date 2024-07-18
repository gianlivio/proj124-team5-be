@extends('layouts.admin')

@section('content')

    <div class="container">
        <h1 class="mt-4 fw-bold">Aggiungi Appartamento</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">

            @csrf

            <div class="form-group">
                <label for="title">Titolo:</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>

            <div class="form-group">
                <label for="address">Indirizzo:</label>
                <input type="text" class="form-control" id="address" name="address" autocomplete="off" required>
                <div id="suggestions" class="list-group mt-2"></div>
            </div>


            <div class="form-group">
                <label for="rooms">Stanze:</label>
                <input type="number" class="form-control" id="rooms" name="rooms" required>
            </div>

            <div class="form-group">
                <label for="beds">Posti letto:</label>
                <input type="number" class="form-control" id="beds" name="beds" required>
            </div>
            <div class="form-group">
                <label for="bathroom">Bagni:</label>
                <input type="number" class="form-control" id="bathroom" name="bathroom" required>
            </div>
            <div class="form-group">
                <label for="square_mt">Metri Quadrati:</label>
                <input type="number" class="form-control" id="square_mt" name="square_mt" required>
            </div>

            <div class="form-group">
                <label for="apartment_description">Descrizione:</label>
                <textarea class="form-control" id="apartment_description" name="apartment_description"></textarea>
            </div>

            <div>
                <label for="inp_img">Immagine appartamento</label>
                <input type="file" name="inp_img" id="inp_img">
            </div>

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="1" id="available" name="available">
                <label class="form-check-label" for="available">
                    Disponibile
                </label>
            </div>

            <div class="mt-2">
                <span>Servizi offerti:</span>
                @foreach ($services as $service)
                    <div class="form-check">
                        <input class="form-check-input" name="services[]" type="checkbox" value="{{ $service->id }}"
                            id="services">
                        <label class="form-check-label" for="services">
                            {{ $service->title }}
                        </label>
                    </div>
                @endforeach
            </div>

            {{-- <div>
                <span>Slug:</span>
                <p class="fw-bold" id="slug"></p>
            </div> --}}

            <button type="submit" id="submit" class="btn btn-primary mt-2" disabled>Aggiungi</button>
            <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary mt-2">Cancella</a>

        </form>

    </div>
    




@endsection
