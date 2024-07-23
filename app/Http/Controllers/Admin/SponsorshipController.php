<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Sponsorship;
use Illuminate\Http\Request;

class SponsorshipController extends Controller
{
    public function store(Request $request)
    {
        $apartmentId = $request->input('apartment_id');
        $sponsorshipTypeId = $request->input('sponsorship_id');



        // Find the apartment and sponsorship type
        $apartment = Apartment::findOrFail($apartmentId);
        $sponsorshipType = Sponsorship::findOrFail($sponsorshipTypeId);

        // Attach the sponsorship type to the apartment
        $apartment->sponsorships()->attach($sponsorshipTypeId);

        return redirect()->route('admin.sponsorship', ['slug' => $request->input('slug')])->with('success', 'Sponsorship added successfully.');
    }
}
