@extends('layouts.admin')

@section('content')
    <div class="container">
        <h1>Seleziona pacchetto</h1>
        <div class="row">
            @foreach ($sponsorships as $sponsor)
                <div class="px-2 col-3">
                    <div class="card h-100">
                        <div class="card-header">
                            Pacchetto: {{$sponsor->type}}
                        </div>
                        <div class="card-body h-100 d-flex flex-column justify-between">
                            <h5 class="card-title">{{$sponsor->type}}</h5>
                            <p class="card-text flex-grow-1">{{$sponsor->sponsorship_description}}</p>
                            <a href="#" class="btn btn-primary {{$sponsor->type == 'Free' ? 'disabled' : null}}">{{$sponsor->type == 'Free' ? 'Free' : 'Acquista'}}</a>
                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    </div>
@endsection
