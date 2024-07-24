@extends('layouts.admin')

@section('content')
    {{-- @include('partials.message-success') --}}
    
    <div class="mt-4">
        <div class="container mt-5 mb-5">
            {{-- <h1 class="text-white"> {{ $apartment->title }}</h1> --}}
            <h1 class="mb-4 fw-bold text-white">{{ $apartment->title }}</h1>

            <div class="card p-4" style="border-radius: 15px; background-color: #fff;">
                <div class="row">
                    <div class="col-6 image-container">
                        @if ($apartment->img_path)
                        <img class="img-fluid" src="{{ asset('storage/' . $apartment->img_path) }}" alt="{{ $apartment->title }}">                 
                        @else
                        <img class="img-fluid" src="https://salonlfc.com/wp-content/uploads/2018/01/image-not-found-1-scaled.png" alt="{{ $apartment->title }}">                 
                        @endif
                    </div>
                    <div class="col-5">
                        <h4>I nostri servizi</h4>
                        @foreach ($apartment->services as $service)
                            <p>{{ $service->title }}</p>
                        @endforeach
                    </div>
                </div>
                <p>{{$apartment->address}}</p>
                <div class="row">
                    <div class="col-6">
                        <p><span class="fw-bold">Descrizione:</span> {{ $apartment->apartment_description }}</p>
                    </div>
                    <div class="col-6">
                        <p><span class="fw-bold">Stanze:</span> {{ $apartment->rooms }}</p>
                    </div>
                </div>
                
                <div class="mt-3"><a class="btn btn-orange" href="{{ route('admin.apartments.index') }}">Indietro</a></div>
            </div>
        </div>
    </div>
@endsection
