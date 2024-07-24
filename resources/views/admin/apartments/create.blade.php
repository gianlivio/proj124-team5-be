@extends('layouts.admin')

@section('content')


    <div class="container mt-5">
        <h1 class="mb-4 text-center fw-bold text-white">Aggiungi Appartamento</h1>

        <!-- Messaggio di successo se l'appartamento è stato aggiunto con successo -->
        {{-- @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif --}}

        <!-- Messaggi di errore se ci sono problemi con la convalida del modulo -->
        {{-- @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif --}}

        <div class="card shadow-sm rounded border-0">
            <div class="card-body p-4">
                <!-- Inizio del modulo per aggiungere un appartamento -->
                <form action="{{ route('admin.apartments.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf <!-- Protezione CSRF per il modulo -->

                    <div class="mb-3">
                        <label for="title" class="form-label">Titolo*:</label>
                        <input type="text" placeholder="Titolo dell'annuncio.."
                            class="form-control form-control-lg @error('title') is-invalid @enderror" id="title"
                            name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="apartment_description" class="form-label">Descrizione:</label>
                        <textarea class="form-control form-control-lg" id="apartment_description" name="apartment_description"
                            placeholder="Scrivi qualcosa sull'appartamento..." rows="4">{{ old('apartment_description') }}</textarea>
                    </div>

                    <!-- Sezione flexbox per disporre i campi in due colonne -->
                    <div class="d-flex flex-wrap">
                        <div class="flex-fill p-2">
                            <div class="form-group mb-3">
                                <label for="address" class="form-label">Indirizzo*:</label>
                                <input type="text" placeholder="Inserisci l'indirizzo.." class="form-control"
                                    id="address" name="address" autocomplete="off" value="{{ old('address') }}" required>
                                <div id="suggestions" class="list-group mt-2"></div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="rooms" class="form-label">Stanze*:</label>
                                <input type="number" min="0" step="1" placeholder="Numero camere.." class="form-control" id="rooms"
                                    name="rooms" value="{{ old('rooms') }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="beds" class="form-label">Posti letto*:</label>
                                <input type="number" min="0" step="1" placeholder="Numero di posti letto.." class="form-control"
                                    id="beds" name="beds" value="{{ old('beds') }}" required>
                            </div>
                        </div>
                        <div class="flex-fill p-2">
                            <div class="form-group mb-4">
                                <label for="bathroom" class="form-label">Bagni*:</label>
                                <input type="number" min="0" step="1" placeholder="Quanti bagni a disposizione dell'ospite.."
                                    class="form-control" id="bathroom" name="bathroom" value="{{ old('bathroom') }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="square_mt" class="form-label">Metri Quadrati*:</label>
                                <input type="number" min="0" step="1" placeholder="Superficie camera.." class="form-control" id="square_mt"
                                    name="square_mt" value="{{ old('square_mt') }}" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="inp_img" class="form-label">Immagine appartamento</label>
                                <input type="file" class="form-control" name="inp_img" id="inp_img" value="{{ old('inp_img') }}">
                            </div>
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" value="1" id="available" name="available" @checked(old('available', []) ? 'checked' : '')>
                        <label class="form-check-label" for="available">
                            Disponibile
                        </label>
                    </div>

                    <div class="mt-2">
                        <span>
                            Servizi offerti:
                        </span>

                        @foreach ($services as $service)
                            <div class="form-check">
                                <input @checked(in_array($service->id, old('services', []))) class="form-check-input" name="services[]" type="checkbox"
                                    value="{{ $service->id }}" id="service{{ $service->id }}">
                                <label class="form-check-label" for="service{{ $service->id }}">
                                    {{ $service->title }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="mb-3">
                        <small class="text-muted">Compila i campi contrassegnati con *.</small>
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="submit" id="submit" class="btn btn-orange">Aggiungi</button>
                        <a href="{{ route('admin.apartments.index') }}" class="btn btn-secondary">Cancella</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
