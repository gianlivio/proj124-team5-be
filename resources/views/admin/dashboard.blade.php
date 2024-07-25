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
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{ __('Login eseguito con successo!') }}
                    </div>
                </div>
            </div>

            {{-- chartjs --}}
            <div>
                <canvas id="myChart"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                // Prepare the data in PHP and pass it to JavaScript
                const labels = @json($viewsCountByApartment->pluck('apartment_id'));
                const data = @json($viewsCountByApartment->pluck('total_views'));

                const ctx = document.getElementById('myChart');

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Andamento visite ai tuoi appartamenti',
                            data: data,
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
