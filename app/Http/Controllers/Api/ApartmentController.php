<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    public function getAddressFromCoordinates($slug){
        $apartment = Apartment::where('slug',$slug)->first();

        if (!$apartment) {
            return response()->json(['error' => 'Appartamento non trovato'], 404);
        }

        $lat = $apartment->latitude;
        $lon = $apartment->longitude;
        $apiKey = env('TOMTOM_API_KEY');

        $url = "https://api.tomtom.com/search/2/reverseGeocode/{$lat},{$lon}.json?key={$apiKey}";

        $client = new Client();

        $response = $client->get($url);
        $data = json_decode($response->getBody(), true);

        $address = $data['addresses'][0]['address']['freeformAddress'];

        return response()->json(['address' => $address]);
    }

    public function getCoordinatesForAddress($address)
    {
        $apiKey = env('TOMTOM_API_KEY');

        $client = new Client();

        // Codifica l'indirizzo per essere utilizzato in un URL
        $encodedAddress = urlencode($address);

        // Url per la richiesta
        $url = "https://api.tomtom.com/search/2/geocode/{$encodedAddress}.json?key={$apiKey}";

        try {
            // Effettua la richiesta GET all'API di TomTom
            $response = $client->get($url);

            // Decodifica la risposta JSON
            $data = json_decode($response->getBody(), true);

            // Estrai le coordinate dalla risposta
            $latitude = $data['results'][0]['position']['lat'];
            $longitude = $data['results'][0]['position']['lon'];

            return ['latitude' => $latitude, 'longitude' => $longitude];
        } catch (\Exception $e) {
            return null;
        }
    }
}
