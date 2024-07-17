@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form id="registerForm" class="needs-validation" novalidate method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="mb-4 row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                <div class="invalid-feedback">
                                    Per favore inserisci il nome.
                                </div>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                <div class="invalid-feedback">
                                    Per favore inserisci l'email.
                                </div>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                                
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" minlength="8" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                <div id="password_fb" class="invalid-feedback">
                                    Per favore inserisci una password.
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Conferma Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                                <div class="invalid-feedback">
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Registrati') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    (function () {
            'use strict';
            window.addEventListener('load', function () {
                let form = document.getElementById('registerForm');
                form.addEventListener('submit', function (event) {
                    let passwordInput = document.getElementById('password');
                    if ( passwordInput.value.length > 0 && passwordInput.value.length < 8) {
                        let feedback_length = document.getElementById("password_fb")
                        console.log(feedback_length.innerHTML);
                        feedback_length.innerHTML = "La password deve essere di almeno 8 caratteri."
                        
                        passwordInput.setCustomValidity('La password deve essere di almeno 8 caratteri.');
                    } else {
                        passwordInput.setCustomValidity('');
                    }

                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false);
            }, false);
        })();
</script>

@endsection
