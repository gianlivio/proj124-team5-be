<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Apartment;
// use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Session;
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
                $defaultRadius = 30; 
                $data = $results->json();

                // Estrai le coordinate dalla risposta
                $latitude = $data['results'][0]['position']['lat'];
                $longitude = $data['results'][0]['position']['lon'];

                $cord = ['latitude' => $latitude, 'longitude' => $longitude ];

                // checkare se available

                $locations = DB::table('apartments')
                ->where('available', 1)
                ->select('title', 'apartment_description', 'rooms', 'beds', 'bathroom', 'square_mt', 'slug')
                ->selectRaw(
                    '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                    [$cord['latitude'], $cord['longitude'], $cord['latitude']]
                )
                ->having('distance', '<=', $defaultRadius) // 30km radius
                ->orderBy('distance')
                ->get();

                $locations = "Milano";
                Session::put('locations', $locations);
                return response()->json($locations);

            } else {
                throw new \Exception('Errore nella richiesta all\'API di TomTom');
            }
        } catch (\Exception $e) {
            return null;
        }
        
        // return response()->json($location);
    }

    public function getFilteredData(Request $request){
        // $query = Apartment::query();
        $query = Session::get('locations');
        dd($query);
        if ($request->has('bathroom')) {
            $query->where('bathroom', $request->input('bathroom'));
        }

        if ($request->has('beds')) {
            $query->where('beds', $request->input('beds'));
        }

        if ($request->has('square_mt')) {
            $query->where('square_mt', $request->input('square_mt'));
        }

        if ($request->has('rooms')) {
            $query->where('rooms', $request->input('rooms'));
        }

        if($request->has('radius')){
            
        }
        $apartments = $query->get();

        return response()->json($apartments);
    }


    public function fetchSponsored() {
        $data = Apartment::where("sponsorship_id", '>=', 3)->paginate(8);

        return response()->json($data);
    }
}
