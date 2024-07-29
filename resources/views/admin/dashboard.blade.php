@extends('layouts.admin')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 mt-4" id="status-alert">
                
                @if (session('status') && !session('first_login'))
                    <div class="alert alert-success bg-light" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    
                    <script>
                        setTimeout(function() {
                           
                        document.getElementById('status-alert').style.display = 'none';
                    }, 5000); // Hide after 5 seconds (5000 milliseconds)
                </script>
            </div>

            <h2 class="fw-bold text-white mt-3">Ecco come vanno i tuoi appartamenti {{ Auth::user()->name }}</h2>

            @if ($viewsCountByApartment->isNotEmpty() || $apartmentLeads->isNotEmpty())
                <div class="row justify-content-between chart-spacing">
                    <div class="col-12 mt-3 chart mb-3 rounded">
                        <h2 class="text-center p-3">Visite agli appartamenti</h2>
                        <canvas class="align-self-baseline" id="viewsChart"></canvas>
                    </div>
                    <div class="col-12 chart mb-3 rounded">
                        <h2 class="text-center p-3">Contatti per appartamento</h2>
                        <canvas id="leadsChart"></canvas>
                    </div>
                </div>
            @else
                <div class="col-12 mt-5 chart mb-5 rounded">
                    <h2 class="text-center p-3">Nessuna statistica disponibile</h2>
                </div>
            @endif

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

            <script>
                // Funzione per generare colori casuali
                function getRandomColor() {
                    const letters = '0123456789ABCDEF';
                    let color = '#';
                    for (let i = 0; i < 6; i++) {
                        color += letters[Math.floor(Math.random() * 16)];
                    }
                    return color;
                }

                // Dati per il grafico delle visite
                const viewsData = @json($viewsCountByApartment);
                const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
                    'November', 'December'
                ];
                let viewDatasets = [];

                Object.keys(viewsData).forEach(apartmentId => {
                    const views = viewsData[apartmentId];
                    const title = views[0].title;
                    let monthlyData = new Array(12).fill(0);

                    views.forEach(view => {
                        monthlyData[view.month - 1] = view.total_views;
                    });

                    viewDatasets.push({
                        label: title,
                        data: monthlyData,
                        borderColor: getRandomColor(),
                        fill: false
                    });
                });

                const viewCtx = document.getElementById('viewsChart').getContext('2d');
                new Chart(viewCtx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: viewDatasets
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Dati per il grafico dei lead
                const leadLabels = @json($apartmentLeads->pluck('title'));
                const leadData = @json($apartmentLeads->pluck('generated_leads'));

                const leadCtx = document.getElementById('leadsChart').getContext('2d');
                new Chart(leadCtx, {
                    type: 'bar',
                    data: {
                        labels: leadLabels,
                        datasets: [{
                            label: 'Contatti per appartamento',
                            data: leadData,
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
            </script>
        </div>
    </div>

    <style>
        .chart-spacing {
            gap: 30px;
        }

        .ms_width {
            width: 50%;
        }
    </style>
@endsection
