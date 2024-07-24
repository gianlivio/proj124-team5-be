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
        </div>
    </div>
@endsection
