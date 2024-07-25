@extends('layouts.admin')

@section('content')
  <div class="container mb-4">
    <div class="ms-table-container mt-5">
        <h1 class="fw-bold text-white">Dettagli del contatto</h1>
        @if (session('success'))
            <div id="success-alert" class="alert alert-success mt-2 bg-white text-orange">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-4 rounded-3 mt-2" id="apartment_list_index">
            <div class="d-flex justify-content-between">
                <h3 class="mb-1" >Nome contatto</h3>
                <div class="d-flex align-items-center justify-content-center mb-2">
                    <span class="pe-4">Hai risposto a questo messaggio?</span>
                    <form id="leadForm-{{ $lead->id }}"
                    action="{{ route('admin.leads.update', ['lead' => $lead->id]) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label class="switch">
                            <input type="checkbox" name="replied" value="1" {{ $lead->replied ? 'checked' : '' }}
                                onchange="document.getElementById('leadForm-{{ $lead->id }}').submit()">
                            <span class="slider round">
                                <span class="slider-text slider-text-left">No</span>
                                <span class="slider-text slider-text-right">Si</span>
                            </span>
                        </label>
                    </form>
                </div>
            </div>
            <p class="p-3 fs-5 mt-3 fw-light border rounded-start rounded-end">{{ $lead->name }}</p>
            <h3 class="mt-4 mb-2">Indirizzo Email</h3>
            <p class="p-3 fs-5 mt-3 fw-light border rounded-start rounded-end">{{ $lead->mail }}</p>
            <h3 class="mt-4 mb-2">Messaggio</h3>
            <p class="p-3 fs-5 fw-light mt-3 border rounded-start rounded-end">{{ $lead->message }}</p>

        
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
@endsection
