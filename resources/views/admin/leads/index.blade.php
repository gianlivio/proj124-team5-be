@extends('layouts.admin')

@section('content')
    <div class="container mb-4">
        <div class="ms-table-container mt-5">
            <h1 class="fw-bold text-white">Lista di richieste di contatto</h1>
            @if (session('success'))
                <div id="success-alert" class="alert alert-success mt-2 bg-white text-orange">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-4 rounded-3 mt-2" id="apartment_list_index">
                <div class="table-responsive">
                    <table class="table">
                        <thead class="fw-bold">
                            <tr>
                                <th style="vertical-align: middle" class="ps-lg-3 rounded-start-3"
                                    scope="col">Nome</th>
                                <th style="vertical-align: middle" class="d-none d-md-table-cell">Email</th>
                                <th style="vertical-align: middle" class="d-none d-lg-table-cell" scope="col">Data</th>
                                <th style="vertical-align: middle" class="d-none d-sm-table-cell" scope="col">
                                    Ricontattato</th>
                                <th style="vertical-align: middle" class="ps-3 rounded-end-3" scope="col">Info</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($leads as $lead)
                                <tr>
                                    <td style="vertical-align: middle" class="">{{ $lead->name }}
                                    </td>
                                    <td style="vertical-align: middle" class="d-none d-lg-table-cell">{{ $lead->mail }}</td>
                                    <td style="vertical-align: middle" class="d-none d-lg-table-cell">
                                        {{ $lead->created_at }}</td>
                                    <td style="vertical-align: middle" class="d-none d-sm-table-cell">
                                        <form id="leadForm-{{ $lead->id }}"
                                            action="{{ route('admin.leads.update', ['lead' => $lead->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <label class="switch">
                                                <input type="checkbox" name="replied" value="1"
                                                    {{ $lead->replied ? 'checked' : '' }}
                                                    onchange="document.getElementById('leadForm-{{ $lead->id }}').submit()">
                                                <span class="slider round">
                                                    <span class="slider-text slider-text-left">No</span>
                                                    <span class="slider-text slider-text-right">Si</span>
                                                </span>
                                            </label>
                                        </form>
                                    </td>
                                    <td style="vertical-align: middle">
                                        <a href="{{ route('admin.leads.show', ['lead' => $lead->id]) }}">Dettagli</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $leads->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- SWITCH STYLE --}}
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 10px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #fe5d26;
        }

        input:checked+.slider:before {
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .slider-text {
            position: absolute;
            width: 100%;
            text-align: center;
            color: white;
            font-size: 12px;
            font-weight: bold;
            line-height: 34px;
        }

        .slider-text-left {
            left: 10px;
        }

        .slider-text-right {
            right: 10px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let successAlert = document.getElementById('success-alert');
            if (successAlert) {
                setTimeout(function() {
                    successAlert.style.opacity = 0;
                    setTimeout(function() {
                        successAlert.style.display = 'none';
                    }, 600); // Extra timeout to allow fade-out effect
                }, 4000); // Adjust the time as needed
            }
        });
    </script>
@endsection
