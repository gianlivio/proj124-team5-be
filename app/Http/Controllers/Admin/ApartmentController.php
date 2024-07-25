<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\ApartmentController as ApiController;
use App\Http\Controllers\Api\AutocompleteController;
use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Braintree\Gateway as BraintreeGateway;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();
        $apartments = Apartment::where('user_id', $user->id)->get();
        // $apartments = Apartment::all();
        
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
        // controllo titolo con nome uguale a titolo esistente
        $request->validate([
            'title' => 'required|unique:apartments,title',
        ], [
            'title.unique' => 'Il titolo dell\'appartamento esiste già. Si prega di scegliere un titolo diverso.',
        ]);

        $data = $request->all();
        // dd($request);
        //? Metto due commenti :-)

        // prendo il valore dell'indirizzo dall'input del form
        $addressInput = $request->input('address');

        //chiamo la funzione dell'api che ho creato in Api/ApartmentController
        //restituisce le coordinate utilizzando l'indirizzo
        // $coordinates = $apiController->getCoordinatesForAddress($address);

        try {
            // Chiamata alla funzione che restituisce le coordinate utilizzando l'indirizzo
            $coordinates = $apiController->getCoordinatesForAddress($addressInput);
        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['address' => 'Impossibile ottenere le coordinate per l\'indirizzo specificato. Riprova più tardi.']);
        }

        if (!$data['beds'] >= 0 or !$data['rooms'] >= 0 or !$data['bathroom'] >= 0 or !$data['square_mt'] >= 0) {
            return back()->withInput()->withErrors(['Non inserire numeri negativi']);
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

            $apartment->available = $request->has('available') ? true : false;
            $apartment->latitude = $coordinates['latitude'];
            $apartment->longitude = $coordinates['longitude'];
                // Chiamata alla funzione che restituisce le coordinate utilizzando l'indirizzo
            $response = $apiController->getAddressFromCoordinates($apartment->latitude, $apartment->longitude);
            $data = json_decode($response->getContent(), true);
            $apartment->address = $data['address'];

            $apartment->user_id = Auth::id();
            $apartment->slug = Str::slug($request->title);
            $apartment->save();

            if ($request->has("services")) {
                $apartment->services()->attach($request->services);
            }

            return redirect()->route('admin.apartments.index')->with('success', 'L\'appartamento ' . $apartment->title . ' è stato aggiunto con successo!');
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

        return view('admin.apartments.show', compact('apartment', 'services', 'sponsorships'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment, ApiController $apiController)
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
        $request->validate([
            'title' => 'required|unique:apartments,title',
        ], [
            'title.unique' => 'Il titolo dell\'appartamento esiste già. Si prega di scegliere un titolo diverso.',
        ]);
        
        $data = $request->all();

        if ($data['beds'] < 1 or $data['rooms'] < 1 or $data['bathroom'] < 1 or $data['square_mt'] < 1) {
            return back()->withInput()->withErrors(['Inserisci un numero maggiore di zero.']);
        }

        $apartment->title = $data['title'];
        $apartment->rooms = $data['rooms'];
        $apartment->bathroom = $data['bathroom'];
        $apartment->beds = $data['beds'];
        $apartment->square_mt = $data['square_mt'];
        $apartment->apartment_description = $data['apartment_description'];

        $apartment->available = $request->has('available') ? true : false;
        $apartment->slug = Str::slug($apartment->title);

        $address = $data['address'];
        $coordinates = $apiController->getCoordinatesForAddress($address);

        if ($coordinates && isset($coordinates['latitude']) && isset($coordinates['longitude'])) {
            $apartment->slug = Str::slug($apartment->title);
            $apartment->latitude = $coordinates['latitude'];
            $apartment->longitude = $coordinates['longitude'];

            $response = $apiController->getAddressFromCoordinates($apartment->latitude, $apartment->longitude);
            $data = json_decode($response->getContent(), true);
            $apartment->address = $data['address'];
            
            if ($request->hasFile('inp_img')) {
                if ($apartment->img_path) {
                    $inp_img = Storage::delete($apartment->img_path);
                }
                $inp_img = Storage::put('apartment_images', $request->file('inp_img'));
                $data['img_path'] = $inp_img;
            }



            $apartment->update($data);
            $apartment->services()->sync($request->services);
            // dd($data);
            return redirect()->route('admin.apartments.index', ['apartment' => $apartment->slug])->with('message', 'L\'appartamento ' . $apartment->title . ' è stato modificato con successo');
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
        return redirect()->route('admin.apartments.index')->with('message', 'L\'appartamento ' . $apartment->title . ' è stato eliminato');
    }

    public function sponsorship_menu() {
        $user = Auth::user();
        $apartments = Apartment::where('user_id', $user->id)->get();
        
        return view('admin.apartments.sponsorship_menu', compact('apartments'));
    }

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


    public function showSponsorshipPage (String $slug) {
        $apartment = Apartment::where("slug", $slug)->firstOrFail();

        $sponsorships = Sponsorship::all();

        $clientToken = $this->gateway->clientToken()->generate();
        
        return view("admin.apartments.sponsorship_selector", compact("apartment", "sponsorships", "clientToken"));
    }
}