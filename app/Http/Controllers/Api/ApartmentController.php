<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Http;
use App\Models\Apartment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;

class ApartmentController extends Controller
{
    

    public function getAddressFromCoordinates($slug)
    {
        $apartment = Apartment::where('slug', $slug)->first();

        if (!$apartment) {
            return response()->json(['error' => 'Appartamento non trovato'], 404);
        }

        $lat = $apartment->latitude;
        $lon = $apartment->longitude;
        $apiKey = env('TOMTOM_API_KEY');

        $url = "https://api.tomtom.com/search/2/reverseGeocode/{$lat},{$lon}.json?key={$apiKey}";

        // $response = Http::get($url);


        $response = Http::withOptions([
            'verify' => false, 
        ])
        ->get($url);

        if ($response->failed()) {
            return response()->json(['error' => 'Errore nell\'ottenimento dell\'indirizzo'], 500);
        }

        $data = $response->json();
        $address = $data['addresses'][0]['address']['freeformAddress'];

        return response()->json(['address' => $address]);
    }


    

    public function getCoordinatesForAddress($address)
    {
        $apiKey = env('TOMTOM_API_KEY');

        $encodedAddress = urlencode($address);

        $url = "https://api.tomtom.com/search/2/geocode/{$encodedAddress}.json?key={$apiKey}";

        try {
            
            // $response = Http::get($url);
            $response = Http::withOptions([
                'verify' => false, 
            ])
            ->get($url);

            if ($response->successful()) {
                
                $data = $response->json();

                // Estrai le coordinate dalla risposta
                $latitude = $data['results'][0]['position']['lat'];
                $longitude = $data['results'][0]['position']['lon'];

                return ['latitude' => $latitude, 'longitude' => $longitude];
            } else {
                throw new \Exception('Errore nella richiesta all\'API di TomTom');
            }
        } catch (\Exception $e) {
            return null;
        }
    }


    public function searchInput (Request $request) {
        $location = $request;
        
        dd($location);
    }

    public function searchApartments() {
        // $api_key = env('TOMTOM_API_KEY');

        

        // $url = "https://api.tomtom.com/search/2/nearbySearch/.json?key={$api_key}&lat={$lat}&lon={$long}";
        
        $apartments = Apartment::all();
        $data = [
            "results" => $apartments,
            "success" => true
        ];
        return response()->json($data);
    }
}
