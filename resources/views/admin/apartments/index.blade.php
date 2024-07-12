@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="ms-table-container mt-5">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="fw-bold">Appartamenti</h1>
                
                <div class="d-flex flex-column">
                    <a href="{{route('admin.apartments.create')}}" class="btn btn-primary fw-bold">Add New </a>
            <span class="fw-bold">Total row: <?= count($apartments)?> </span>

                </div>
                
            </div>
            <hr>
            
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Titolo</th>
                        <th scope="col">Stanze</th>
                        <th scope="col">Letti</th>
                        <th scope="col">Bagni</th>
                        <th scope="col">Metri Quadrati</th>
                        <th scope="col">Disponibile</th>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach ($apartments as $curApartment)
                            <tr>
                                <th scope="row">{{ $loop->index + 1}}</th>
                                <td>{{ $curApartment->title }}</td>
                                <td>{{ $curApartment->rooms }}</td>
                                <td>{{ $curApartment->beds }}</td>
                                <td>{{ $curApartment->square_mt }}</td>
                                <td>{{ $curApartment->available }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.apartments.show',['apartment'=>$curApartment->slug])  }}" class="btn btn-success fw-bold text-light">Dettagli</a>
                                        <a href="{{ route('admin.apartments.edit',['apartment'=>$curApartment->slug])  }}" class="btn btn-warning fw-bold text-light">Modifica</a>
                                        <form action="{{ route('admin.apartments.destroy', ['apartment' => $curApartment->slug]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn fw-bold btn-danger" onclick="return confirm('Sei sicuro di voler procedere?')">Elimina</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        
                    </tbody>
                </table>
        </div>
    </div>
@endsection