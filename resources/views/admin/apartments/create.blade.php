@extends('layouts.admin')


@section('content')

<div class="container">
    <h1 class="mt-4 fw-bold">Aggiungi Appartamento</h1>
    
    @if(session('success'))
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

    <form action="{{ route('admin.apartments.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="title">Titolo:</label>
            <input type="text" class="form-control" id="title" name="title">
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
        
        
        {{-- <span>Sponsorship:</span>
        <select class="form-select" name="sponsorship_id" id="sponsorship_id">

            <option value=""></option>
            @foreach($sponsorships as $sponsorship)
                <option value="{{ $sponsorship->id }}">{{ $sponsorship->title }}</option>
            @endforeach
        </select> --}}

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="available">
            <label class="form-check-label" for="available">
              Disponibile
            </label>
        </div>

        <div>
            <span>Slug:</span>
            <p class="fw-bold" id="slug"></p>
        </div>

        
        

        <button type="submit" class="btn btn-primary mt-2">Add</button>
        <a href="{{route('admin.apartments.index')}}" class="btn btn-secondary mt-2">Cancel</a>

    </form>
    
</div>




@endsection