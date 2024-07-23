<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Braintree\Gateway as BraintreeGateway;


class SponsorshipController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        $this->gateway = new BraintreeGateway([
            'environment' => config('braintree.environment'),
            'merchantId' => config('braintree.merchantId'),
            'publicKey' => config('braintree.publicKey'),
            'privateKey' => config('braintree.privateKey'),
        ]);
    }



    public function store(Request $request)
    {
        $apartmentId = $request->input('apartment_id');
        $sponsorshipTypeId = $request->input('sponsorship_id');
        $nonce = $request->input('payment_method_nonce');


        // Find the apartment and sponsorship type
        $apartment = Apartment::findOrFail($apartmentId);
        $sponsorshipType = Sponsorship::findOrFail($sponsorshipTypeId);

        //Convert Decimal to String
        $amount = number_format($sponsorshipType->price, 2, '.', '');

         // Process the payment
        $result = $this->gateway->transaction()->sale([
            'amount' => $amount,
            'paymentMethodNonce' => $nonce,
            'options' => [
                'submitForSettlement' => true
            ]
        ]);

        if ($result->success) {
            // Attach the sponsorship type to the apartment
            $apartment->sponsorships()->attach($sponsorshipTypeId);

            return redirect()->route('admin.sponsorship')->with('success', 'Sponsorship added successfully.');
        } else {
            return back()->withErrors('Pagamento non andato a buon fine si prega di riprovare.');
        }
    }
}
