@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sponsor {{ $apartment->name }}</h1>
    <p>{{ $apartment->description }}</p>
    
    <!-- Sponsorship Form -->
    <form action="{{ route('admin.sponsorship.store') }}" method="POST">
        @csrf
        <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">


         <!-- Sponsorship Type Select -->
         <div class="form-group">
            <label for="sponsorship_type">Select Sponsorship Type:</label>
            <select name="sponsorship_id" id="sponsorship_type" class="form-control" required>
                @foreach($sponsorships as $sponsorship)
                    <option value="{{ $sponsorship->id }}">{{ $sponsorship->type }}</option>
                @endforeach
            </select>
        </div>
        <!-- Add other sponsorship form fields here -->
        <button type="submit" class="btn btn-primary">Sponsor</button>
    </form>
</div>
@endsection