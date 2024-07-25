@extends('layouts.app')
@section('content')

<div class="jumbotron p-5 mb-4 bg-light rounded-3" style="height: 100%">
    <div class="container py-5">
        <div class="logo_laravel d-inline">
            <img class="w-25" src="{{url('boolbnb_logo.png')}}" alt="">
        </div>
        <h1 class="display-5 fw-bold">
            Benvenuto su BoolBnB
        </h1>

        <p class="col-md-8 fs-4">La Dashboard che ti permette di gestire i tuoi appartamenti in giro per il mondo.</p>
    </div>
</div>

@endsection
