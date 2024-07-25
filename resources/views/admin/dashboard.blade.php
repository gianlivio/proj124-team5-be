@extends('layouts.admin')

@section('content')
    <div class="container d-flex justify-content-end">
        <a href="http://localhost:5174">
            <button type="button" class="btn btn-primary mt-3 btn-orange">Torna alla pagina home</button>
        </a>
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 mt-4">
                <div class="card">
                    <div class="card-body text-center">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('Login eseguito con successo!') }}
                    </div>
                </div>
            </div>
{{-- @dd($viewsCountByApartment) --}}
            {{-- CHART CONTAINER --}}
            {{-- @if (!empty($viewsCountByApartment))    
            <div class="col-12 mt-5 chart mb-5">
                <h2 class="text-center p-3">statistiche</h2>
                <canvas id="myChart"></canvas>
            </div>
            @endif --}}

            @if ($viewsCountByApartment->isNotEmpty())
            <div class="col-12 mt-5 chart mb-5">
                <h2 class="text-center p-3">statistiche</h2>
                <canvas id="myChart"></canvas>
            </div>
            @else
            <div class="col-12 mt-5 chart mb-5">
                <h2 class="text-center p-3">nessuna statistica</h2>
            </div>
                
            @endif



            {{-- CHART SCRIPT --}}
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                const labels = @json($viewsCountByApartment->pluck('title'));
                const data = @json($viewsCountByApartment->pluck('total_views'));

                const ctx = document.getElementById('myChart');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Andamento visite ai tuoi appartamenti',
                            data: data,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.6)',
                                'rgba(255, 159, 64, 0.6)',
                                'rgba(255, 205, 86, 0.6)',
                                'rgba(75, 192, 192, 0.6)',
                                'rgba(54, 162, 235, 0.6)',
                                'rgba(153, 102, 255, 0.6)',
                                'rgba(201, 203, 207, 0.6)'
                            ],
                            borderColor: [
                                'rgb(255, 99, 132)',
                                'rgb(255, 159, 64)',
                                'rgb(255, 205, 86)',
                                'rgb(75, 192, 192)',
                                'rgb(54, 162, 235)',
                                'rgb(153, 102, 255)',
                                'rgb(201, 203, 207)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>
@endsection
