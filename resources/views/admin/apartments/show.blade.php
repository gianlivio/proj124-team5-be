@extends('layouts.admin')

@section('content')

{{-- @include('partials.message-success') --}}
<div class="mt-4">
    <p><span class="fw-bold">Appartamento:</span> {{ $apartment->title }}</p>
    <p><span class="fw-bold">Descrizione Appartamento:</span> {{ $apartment->apartment_description }}</p>
    <p><span class="fw-bold">Numero stanze:</span> {{ $apartment->rooms }}</p>
    {{-- <img class="w-25" src="{{asset('storage/' . $apartment->cover_img) }}" alt="{{ $apartment->title }}"> --}}

    <h4>I nostri servizi</h4>
    @foreach ($services as $service)              
    <p>{{ $service->title }}</p>
    @endforeach
    <div class="mt-3"><a class="btn btn-primary" href="{{ route('admin.apartments.index') }}">Back</a></div>
</div>

@endsection