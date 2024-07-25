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

            @if ($viewsCountByApartment->isNotEmpty())
                <div class="row justify-content-between">
                    <div class="col-5 mt-5 chart mb-5">
                        <h2 class="text-center p-3">Visite agli appartamenti</h2>
                        <canvas id="viewsChart"></canvas>
                    </div>
                    <div class="col-5 mt-5 chart mb-5">
                        <h2 class="text-center p-3">Contatti per appartamento</h2>
                        <canvas id="leadsChart"></canvas>
                    </div>
                </div>
            @else
                <div class="col-12 mt-5 chart mb-5">
                    <h2 class="text-center p-3">Nessuna statistica disponibile</h2>
                </div>
            @endif

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                const viewLabels = @json($viewsCountByApartment->pluck('title'));
                const viewData = @json($viewsCountByApartment->pluck('total_views'));

                const leadLabels = @json($apartmentLeads->pluck('title'));
                const leadData = @json($apartmentLeads->pluck('generated_leads'));

                const viewCtx = document.getElementById('viewsChart').getContext('2d');
                const leadCtx = document.getElementById('leadsChart').getContext('2d');

                new Chart(viewCtx, {
                    type: 'bar',
                    data: {
                        labels: viewLabels,
                        datasets: [{
                            label: 'Visite agli appartamenti',
                            data: viewData,
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)'
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

                new Chart(leadCtx, {
                    type: 'polarArea',
                    data: {
                        labels: leadLabels,
                        datasets: [{
                            label: 'Contatti per appartamento',
                            data: leadData,
                            backgroundColor: [
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(201, 203, 207, 0.2)',
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(255, 159, 64, 0.2)',
                                'rgba(255, 205, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
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
