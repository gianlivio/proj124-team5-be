@extends('layouts.admin')

@section('content')

<div class="container mt-5">
    <h1 class="mb-4 text-center fw-bold">Aggiungi Appartamento</h1>

    <!-- Messaggio di successo se l'appartamento è stato aggiunto con successo -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Messaggi di errore se ci sono problemi con la convalida del modulo -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card shadow-sm rounded border-0">
        <div class="card-body p-4">
            <!-- Inizio del modulo per aggiungere un appartamento -->
            <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">

                @csrf <!-- Protezione CSRF per il modulo -->

                <div class="mb-3">
                    <label for="title" class="form-label">Titolo*:</label>
                    <input type="text" placeholder="Titolo dell'annuncio.." class="form-control form-control-lg @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="apartment_description" class="form-label">Descrizione:</label>
                    <textarea class="form-control form-control-lg" id="apartment_description" name="apartment_description" placeholder="Scrivi qualcosa sull'appartamento..." rows="4"></textarea>
                </div>

                <!-- Sezione flexbox per disporre i campi in due colonne -->
                <div class="d-flex flex-wrap">
                    <div class="flex-fill p-2">
                        <div class="form-group mb-3">
                            <label for="address" class="form-label">Indirizzo*:</label>
                            <input type="text" placeholder="Inserisci l'indirizzo.." class="form-control" id="address" name="address" autocomplete="off" required>
                            <div id="suggestions" class="list-group mt-2"></div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="rooms" class="form-label">Stanze*:</label>
                            <input type="number" placeholder="Numero camere.." class="form-control" id="rooms" name="rooms" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="beds" class="form-label">Posti letto*:</label>
                            <input type="number" placeholder="Numero di posti letto.." class="form-control" id="beds" name="beds" required>
                        </div>
                    </div>
                    <div class="flex-fill p-2">
                        <div class="form-group mb-4">
                            <label for="bathroom" class="form-label">Bagni*:</label>
                            <input type="number" placeholder="Quanti bagni a disposizione dell'ospite.." class="form-control" id="bathroom" name="bathroom" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="square_mt" class="form-label">Metri Quadrati*:</label>
                            <input type="number" placeholder="Superficie camera.." class="form-control" id="square_mt" name="square_mt" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="inp_img" class="form-label">Immagine appartamento</label>
                            <input type="file" class="form-control" name="inp_img" id="inp_img">
                        </div>
                    </div>
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" value="1" id="available" name="available">
                    <label class="form-check-label" for="available">
                        Disponibile
                    </label>
                </div>

                <div class="mb-3">
                    <div class="dropdown">
                        <span class="dropdown-toggle form-label" id="servicesDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Servizi offerti <i class="bi bi-chevron-down"></i>
                        </span>
                        <ul class="dropdown-menu p-3" aria-labelledby="servicesDropdown" style="max-height: 300px; overflow-y: auto;">
                            @foreach ($services as $service)
                                <li>
                                    <div class="form-check ms-3">
                                        <input class="form-check-input" name="services[]" type="checkbox" value="{{ $service->id }}" id="service{{ $service->id }}">
                                        <label class="form-check-label" for="service{{ $service->id }}">
                                            {{ $service->title }}
                                        </label>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Compila i campi contrassegnati con *.</small>
                </div>

                <div class="d-flex justify-content-between">
                    <button type="submit" id="submit" class="btn btn-primary">Aggiungi</button>
                    <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary">Cancella</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection