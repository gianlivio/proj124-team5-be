@extends('layouts.admin')

@section('content')
    <h1>Lista di richieste di contatti</h1>

    @if (session('success'))
            <div id="success-alert" class="alert alert-success mt-2 bg-white text-orange">
                {{ session('success') }}
            </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th scope="col">id</th>
                <th scope="col">Nome</th>
                <th scope="col">Email</th>
                <th scope="col">Data</th>
                <th scope="col">Risposto</th>
                <th scope="col">Azioni</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($leads as $lead)
                <tr>
                    <th scope="row">{{ $lead->id }}</th>
                    <td>{{ $lead->name }}</td>
                    <td>{{ $lead->mail }}</td>
                    <td>{{ $lead->created_at }}</td>
                    <td>
                        <form id="leadForm-{{ $lead->id }}"
                            action="{{ route('admin.leads.update', ['lead' => $lead->id]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <label class="switch">
                                <input type="checkbox" name="replied" value="1" {{ $lead->replied ? 'checked' : '' }}
                                    onchange="document.getElementById('leadForm-{{ $lead->id }}').submit()">
                                <span class="slider round"></span>
                            </label>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('admin.leads.show', ['lead' => $lead->id]) }}">Dettagli</a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        {{ $leads->links() }}
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
