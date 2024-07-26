@extends('layouts.admin')

@section('content')

<div class="container mt-5 mb-5">
    <h1 class="text-white fw-bold">Sponsorizzazione per <i>{{ $apartment->title }}</i></h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="bg-white p-4 rounded-3 mt-2">
        <div class="row d-flex">
            @foreach ($sponsorships as $sponsor)
                <div class="col-12 col-md-6 col-lg-3 py-2">
                    <div class="card h-100 mx-1 mb-2">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{$sponsor->type}}</h5>
                        </div>
                        <div class="card-body d-flex flex-column justify-between">
                            <p class="card-text flex-grow-1">{{$sponsor->sponsorship_description}}</p>
                            <p>Prezzo - <strong>{{ $sponsor->price }}€</strong></p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="payment-form mt-3">
            <!-- Sponsorship Form -->
            <form action="{{ route('admin.sponsorship.store') }}" method="POST" id="payment-form">
                @csrf
                <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">
    
    
                <!-- Sponsorship Type Select -->
                <div class="form-group">
                    <label for="sponsorship_type">Seleziona il piano scelto</label>
                    <select name="sponsorship_id" id="sponsorship_type" class="form-control" required>
                        @foreach($sponsorships as $index => $sponsorship)
                            <option value="{{ $sponsorship->id }}" @if($index === 0) disabled @endif>{{ $sponsorship->type }} - {{ $sponsorship->price }}€</option>
                        @endforeach
                    </select>
                </div>
    
                <div id="dropin-container">
    
                </div>
    
                <button type="submit" class="btn btn-edit">Paga ora</button>
    
                <!-- Add other sponsorship form fields here -->
            </form>
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

<script src="https://js.braintreegateway.com/web/dropin/1.33.7/js/dropin.min.js"></script>
<script>
    var form = document.querySelector('#payment-form');
    var clientToken = "{{ $clientToken }}";

    braintree.dropin.create({
        authorization: clientToken,
        container: '#dropin-container'
    }, function (createErr, instance) {
        if (createErr) {
            console.log('Create Error', createErr);
            return;
        }
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            instance.requestPaymentMethod(function (err, payload) {
                if (err) {
                    console.log('Request Payment Method Error', err);
                    return;
                }

                // Add the nonce to the form and submit
                var nonceInput = document.createElement('input');
                nonceInput.setAttribute('type', 'hidden');
                nonceInput.setAttribute('name', 'payment_method_nonce');
                nonceInput.setAttribute('value', payload.nonce);
                form.appendChild(nonceInput);

                form.submit();
            });
        });
    });
</script>
@endsection