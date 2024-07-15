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
}
