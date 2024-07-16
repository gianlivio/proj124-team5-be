<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApartmentController as ApiController;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::all();
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        $sponsorships = Sponsorship::all();
        return view('admin.apartments.create', compact('services', 'sponsorships'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, ApiController $apiController)
{
    $data = $request->all();
    $address = $request->input('address');

    try {
        $coordinates = $apiController->getCoordinatesForAddress($address);
        // dd($coordinates);
    } catch (\Exception $e) {
        return back()->withInput()->withErrors(['address' => 'Impossibile ottenere le coordinate per l\'indirizzo specificato. Riprova più tardi.']);
    }

    if ($coordinates && isset($coordinates['latitude'], $coordinates['longitude'])) {
        $apartment = new Apartment();
        $apartment->fill($data);
        $apartment->available = true;
        $apartment->latitude = $coordinates['latitude'];
        $apartment->longitude = $coordinates['longitude'];
        $apartment->user_id = Auth::id();
        $apartment->slug = Str::slug($request->title);
        $apartment->save();
        return redirect()->route('admin.apartments.show', compact('apartment'));
    } else {
        return back()->withInput()->withErrors(['address' => 'Impossibile ottenere le coordinate per l\'indirizzo specificato']);
    }
}

    /**
     * Display the specified resource.
     */

    public function show(Apartment $apartment, ApiController $apiController)
    {
        $services = Service::all();
        $sponsorships = Sponsorship::all();

        $response = $apiController->getAddressFromCoordinates($apartment->slug);
        $data = $response->getData();

        if (isset($data->address)) {
            $address = $data->address;
        }

        return view('admin.apartments.show', compact('apartment', 'services', 'sponsorships', 'address'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        $services = Service::all();
        $sponsorships = Sponsorship::all();
        return view('admin.apartments.edit', compact('apartment', 'services', 'sponsorships'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartment $apartment, ApiController $apiController)
    {
        $data = $request->all();
        $apartment->slug = Str::slug($apartment->title);

        $address = $request->input('address');
        $coordinates = $apiController->getCoordinatesForAddress($address);

        if ($coordinates && isset($coordinates['latitude']) && isset($coordinates['longitude'])) {
            $apartment->slug = Str::slug($apartment->title);
            $apartment->latitude = $coordinates['latitude'];
            $apartment->longitude = $coordinates['longitude'];

            $apartment->update($data);
            return redirect()->route('admin.apartments.show', ['apartment' => $apartment->slug])->with('message', 'apartment ' . $apartment->title . '  è stato modificato');
        } else {
            return back()->withInput()->withErrors(['address' => 'Impossibile ottenere le coordinate per l\'indirizzo specificato']);
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        // $apartment->sponsorships()->detach();
        // $apartment->services()->detach();
        $apartment->delete();
        return redirect()->route('admin.apartments.index')->with('message', 'apartment ' . $apartment->title . ' è stato cancellato');
    }
}
