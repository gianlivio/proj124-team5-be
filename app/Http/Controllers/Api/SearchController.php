<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    
    
    public function searchApartments(Request $request) {
        $input = $request->input('input');

        $apiKey = env('TOMTOM_API_KEY');

        $encodedAddress = urlencode($input);

        $url = "https://api.tomtom.com/search/2/geocode/{$encodedAddress}.json?key={$apiKey}";
        

        try {
            
            // $response = Http::get($url);
            $results = Http::withOptions([
                'verify' => false, 
            ])
            ->get($url);

            if ($results->successful()) {
                
                $data = $results->json();

                // Estrai le coordinate dalla risposta
                $latitude = $data['results'][0]['position']['lat'];
                $longitude = $data['results'][0]['position']['lon'];

                $cord = ['latitude' => $latitude, 'longitude' => $longitude ];

                

                $locations = DB::table('apartments')
                ->select('title', 'latitude', 'longitude')
                ->selectRaw(
                    '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                    [$cord['latitude'], $cord['longitude'], $cord['latitude']]
                )
                ->having('distance', '<', 2) // 2km radius
                ->orderBy('distance')
                ->get();

                
                return response()->json($locations);

            } else {
                throw new \Exception('Errore nella richiesta all\'API di TomTom');
            }
        } catch (\Exception $e) {
            return null;
        }
        
        // return response()->json($location);
    }
}
