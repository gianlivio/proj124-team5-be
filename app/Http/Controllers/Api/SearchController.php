<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
class SearchController extends Controller
{     
    public function searchApartments(Request $request) {
        $input = $request->input('input');
        $radius = $request->input('radius', 15); // Default radius to 30 if not provided

        $apiKey = env('TOMTOM_API_KEY');
        $encodedAddress = urlencode($input);
        $url = "https://api.tomtom.com/search/2/geocode/{$encodedAddress}.json?key={$apiKey}";

        try {
            $results = Http::withOptions([
                'verify' => false,
            ])->get($url);

            if ($results->successful()) {
                $data = $results->json();

                // Estrai le coordinate dalla risposta
                $latitude = $data['results'][0]['position']['lat'];
                $longitude = $data['results'][0]['position']['lon'];

                $cord = ['latitude' => $latitude, 'longitude' => $longitude];

                // checkare se available
                $locations = DB::table('apartments')
                    ->where('available', 1)
                    ->select('title', 'apartment_description', 'rooms', 'beds', 'bathroom', 'square_mt', 'slug', 'img_path', 'id', 'sponsorship_id','address')
                    ->selectRaw(
                        '(6371 * acos(cos(radians(?)) * cos(radians(latitude)) * cos(radians(longitude) - radians(?)) + sin(radians(?)) * sin(radians(latitude)))) AS distance',
                        [$cord['latitude'], $cord['longitude'], $cord['latitude']]
                    )
                    ->having('distance', '<=', $radius) // Use the radius from the request
                    ->orderBy('distance')
                    ->get();

                Cache::put('locations', $locations, 500);
                return response()->json($locations);
            } else {
                throw new \Exception('Errore nella richiesta all\'API di TomTom');
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // public function getFilteredData(Request $request){
    //     // $query = Apartment::query();
    //     $data = Cache::get('location');
    //     // dd($data);
    //     $query = collect($data);
    //     // dd($query);
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
    //     $apartments = $query->all();

    //     return response()->json($apartments);
    // }
    public function getFilteredData(Request $request){
    
        $data = Cache::get('locations');
        $query = collect($data);
    
        
        if ($request->has('bathroom')) {
            $query = $query->where('bathroom', $request->input('bathroom'));
        }
    
        if ($request->has('beds')) {
            $query = $query->where('beds', $request->input('beds'));
        }
    
        if ($request->has('square_mt')) {
            $query = $query->where('square_mt', $request->input('square_mt'));
        }
    
        if ($request->has('rooms')) {
            $query = $query->where('rooms', $request->input('rooms'));
        }
    
        if ($request->has('radius')) {
           //TO DO 
        }
    
        $apartments = $query->all();
    
        return response()->json($apartments);
    }
    


    public function fetchSponsored() {
        $apartments = Apartment::where("sponsorship_id", '>=', 3)->paginate(3);

        return response()->json($apartments);
    }

    public function fetchSponsoredAll() {
        $allApartments = Apartment::where("sponsorship_id", '>=', 3)->limit(4)->get();

        return response()->json($allApartments);
    }
}
