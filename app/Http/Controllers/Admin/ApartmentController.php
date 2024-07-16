<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApartmentController as ApiController;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();
        $apartments = Apartment::where('user_id', $user->id)->get();
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Display a listing of the resource.
     */
    public function list_sponsor(Apartment $apartment)
    {
        $sponsorships = Sponsorship::all();
        return view('admin.apartments.sponsor', compact('apartment', 'sponsorships'));
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

        //? Metto due commenti :-)

        // prendo il valore dell'indirizzo dall'input del form
        $address = $request->input('address');

        //chiamo la funzione dell'api che ho creato in Api/ApartmentController
        //restituisce le coordinate utilizzando l'indirizzo
        // $coordinates = $apiController->getCoordinatesForAddress($address);

        try {
            // Chiamata alla funzione che restituisce le coordinate utilizzando l'indirizzo
            $coordinates = $apiController->getCoordinatesForAddress($address);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['address' => 'Impossibile ottenere le coordinate per l\'indirizzo specificato. Riprova più tardi.']);
        }

        if ($request->hasFile('inp_img')) {
            $inp_img = Storage::put('apartment_images', $request->file('inp_img'));
            $data['img_path'] = $inp_img;
        }

        if (!isset($data['sponsorship_id'])) {
            $data['sponsorship_id'] = 1; 
        }

        $apartment = new Apartment();
        $apartment->fill($data);
        $apartment->user_id = Auth::id();

        //se esistono le coordinate salvo i dati e mostro la show
        if ($coordinates && isset($coordinates['latitude']) && isset($coordinates['longitude'])) {

            $apartment->available = true;
            $apartment->latitude = $coordinates['latitude'];
            $apartment->longitude = $coordinates['longitude'];
            $apartment->user_id = Auth::id();
            $apartment->slug = Str::slug($request->title);
            $apartment->save();
            return redirect()->route('admin.apartments.show', compact('apartment'));
        }
        //altrimenti ritorno alla pagina del create con tutti i dati (questo poi non dovrebbe essere necessario con il Request Validation)
        else {
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
    public function edit(Apartment $apartment, ApiController $apiController)
    {
        $services = Service::all();
        $sponsorships = Sponsorship::all();
        $response = $apiController->getAddressFromCoordinates($apartment->slug);
        $data = $response->getData();

        if (isset($data->address)) {
            $address = $data->address;
        }
        return view('admin.apartments.edit', compact('apartment', 'services', 'sponsorships','address'));
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

        if ($request->hasFile('inp_img')) {
            if ($apartment->img_path) {
                $inp_img = Storage::delete($apartment->img_path); 
            }
            $inp_img = Storage::put('apartment_images', $request->file('inp_img')); 
            $data['img_path'] = $inp_img;
        }

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
