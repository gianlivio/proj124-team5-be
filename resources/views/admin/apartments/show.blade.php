@extends('layouts.admin')

@section('content')
    {{-- @include('partials.message-success') --}}
    <div class="mt-4">
        <div class="container">
            <h1><span class="fw-bold"></span> {{ $apartment->title }}</h1>
            <div class="row">
                <div class="col-8">
                    @if ($apartment->img_path)
                    <img class="h-25" src="{{ asset('storage/' . $apartment->img_path) }}" alt="{{ $apartment->title }}">                 
                    @else
                    <img class="img-fluid" src="https://salonlfc.com/wp-content/uploads/2018/01/image-not-found-1-scaled.png" alt="{{ $apartment->title }}">                 
                    @endif
                </div>
                <div class="col-4">
                    <h4>I nostri servizi</h4>
                    @foreach ($services as $service)
                        <p>{{ $service->title }}</p>
                    @endforeach
                </div>
            </div>
            <p>{{$address}}</p>
            <div class="row">
                <div class="col-6">
                    <p><span class="fw-bold">Descrizione:</span> {{ $apartment->apartment_description }}</p>
                </div>
                <div class="col-6">
                    <p><span class="fw-bold">Stanze:</span> {{ $apartment->rooms }}</p>
                </div>
            </div>
            
            <div class="mt-3"><a class="btn btn-primary" href="{{ route('admin.apartments.index') }}">Indietro</a></div>
        </div>

    </div>
@endsection
