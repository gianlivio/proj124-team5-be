<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

    // public function getFilteredData(Request $request){
    //     $query = Apartment::query();

    //     if ($request->has('bathroom')) {
    //         $query->where('bathroom', $request->input('bathroom'));
    //     }

    //     if ($request->has('beds')) {
    //         $query->where('beds', $request->input('beds'));
    //     }

    //     if ($request->has('square_mt')) {
    //         $query->where('square_mt', $request->input('square_mt'));
    //     }

    //     if ($request->has('rooms')) {
    //         $query->where('rooms', $request->input('rooms'));
    //     }

    //     if($request->has('radius')){
            
    //     }
    //     $apartments = $query->get();

    //     return response()->json($apartments);
    // }

    // public function getFilteredData(Request $request){
    //     $cord = [
    //         'latitude' => $request->input('latitude'),
    //         'longitude' => $request->input('longitude')
    //     ];
    //     $defaultRadius = 30; // 30km radius
    
    //     $query = Apartment::query()
    //                 ->where('available', 1)
    //                 ->selectRaw(
    //                     '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
    //                     [$cord['latitude'], $cord['longitude'], $cord['latitude']]
    //                 );
    
    //     if ($request->has('bathroom')) {
    //         $query->where('bathroom', $request->input('bathroom'));
    //     }
    
    //     if ($request->has('beds')) {
    //         $query->where('beds', $request->input('beds'));
    //     }
    
    //     if ($request->has('square_mt')) {
    //         $query->where('square_mt', $request->input('square_mt'));
    //     }
    
    //     if ($request->has('rooms')) {
    //         $query->where('rooms', $request->input('rooms'));
    //     }

    //     if ($request->has('title')) {
    //         $query->where('title', $request->input('title'));
    //     }
    
    //     $radius = $request->has('radius') ? $request->input('radius') : $defaultRadius;
    
    //     $query->having('distance', '<=', $radius)
    //           ->orderBy('distance');
    
    //     $apartments = $query->get();
    
    //     return response()->json($apartments);
    // }
    
    

}
