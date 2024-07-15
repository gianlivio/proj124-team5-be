@extends('layouts.admin')

@section('content')
    {{-- @include('partials.message-success') --}}
    <div class="mt-4">
        <div class="container">
            <h1><span class="fw-bold"></span> {{ $apartment->title }}</h1>
            <div class="row">
                <div class="col-8">
                    <img class="w-25" src="{{ asset('storage/' . $apartment->img_path) }}" alt="{{ $apartment->title }}">
                </div>
                <div class="col-4">
                    <h4>I nostri servizi</h4>
                    @foreach ($services as $service)
                        <p>{{ $service->title }}</p>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-6">
                    <p><span class="fw-bold">Descrizione Appartamento:</span> {{ $apartment->apartment_description }}</p>
                </div>
                <div class="col-6">
                    <p><span class="fw-bold">Numero stanze:</span> {{ $apartment->rooms }}</p>
                </div>
            </div>
            
            <div class="mt-3"><a class="btn btn-primary" href="{{ route('admin.apartments.index') }}">Back</a></div>
        </div>

    </div>
@endsection
