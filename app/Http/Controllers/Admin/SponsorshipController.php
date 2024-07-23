<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Braintree\Gateway as BraintreeGateway;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        // dd('Sponsorship Type:', $sponsorshipType->toArray());

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
            DB::transaction(function () use ($apartmentId, $sponsorshipTypeId, $sponsorshipType) {
                $currentEndDate = DB::table('apartment_sponsorship')
                    ->where('apartment_id', $apartmentId)
                    ->where('sponsorship_id', $sponsorshipTypeId)
                    ->value('end_date');

                // If there's an existing record, calculate the new end date based on the existing end date
                if ($currentEndDate) {
                    $currentEndDate = Carbon::parse($currentEndDate);
                    $durationDays = Carbon::parse($sponsorshipType->duration)->diffInDays(Carbon::now());
                    $newEndDate = $currentEndDate->addDays($durationDays);
                } else {
                    // If no existing record, set the end date from now
                    $durationDays = Carbon::parse($sponsorshipType->duration)->diffInDays(Carbon::now());
                    $newEndDate = Carbon::now()->addDays($durationDays);
                }

                // Update or insert the record
                DB::table('apartment_sponsorship')->updateOrInsert(
                    ['apartment_id' => $apartmentId, 'sponsorship_id' => $sponsorshipTypeId],
                    ['end_date' => $newEndDate->format('Y-m-d H:i:s')]
                );
            });

            

            return redirect()->route('admin.sponsorship')->with('success', 'Sponsorizzazione aggiunta corretamente.');
        } else {
            return back()->withErrors('Pagamento non andato a buon fine si prega di riprovare.');
        }
    }
}
