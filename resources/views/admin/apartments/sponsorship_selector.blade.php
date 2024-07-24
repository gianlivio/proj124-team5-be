@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sponsor {{ $apartment->title }}</h1>
    
    


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <!-- Sponsorship Form -->
    <form action="{{ route('admin.sponsorship.store') }}" method="POST" id="payment-form">
        @csrf
        <input type="hidden" name="apartment_id" value="{{ $apartment->id }}">


        <!-- Sponsorship Type Select -->
        <div class="form-group">
            <label for="sponsorship_type">Select Sponsorship Type:</label>
            <select name="sponsorship_id" id="sponsorship_type" class="form-control" required>
                @foreach($sponsorships as $index => $sponsorship)
                    <option value="{{ $sponsorship->id }}" @if($index === 0) disabled @endif>{{ $sponsorship->type }} - {{ $sponsorship->price }}€</option>
                @endforeach
            </select>
        </div>

        <div id="dropin-container"></div>


        <!-- Add other sponsorship form fields here -->
        <button type="submit" class="btn btn-primary">Sponsor</button>
    </form>
</div>


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