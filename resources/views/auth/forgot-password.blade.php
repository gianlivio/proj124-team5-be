@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="mb-4 row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail  ') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-4 row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Invia link di reset') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn {
       background-color:  #FE5D26;
       border-color: #FE5D26
    }

    .btn:hover {
       background-color:  #f78660;
       border-color: #FE5D26
    }

    a {
        color: #FE5D26;
    }

    .btn:first-child:active {
        border-color: #f78660;
        background-color:  #f78660;
    }

    .form-control:focus {
    color: var(--bs-body-color);
    background-color: #f5eeeb;
    border-color: #f78660;
    outline: 0;
    box-shadow: 0 0 5px 0.5px #f78660;
    }

    .form-check-input:focus {
    box-shadow: 0 0 5px 0.5px #f78660;
    }
</style>
@endsection
