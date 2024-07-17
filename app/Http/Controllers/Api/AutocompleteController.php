<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AutocompleteController extends Controller
{
    public function search(Request $request){
        $query = $request->input('query');

        if (strlen($query) < 3) {
            return response()->json([]);
        }

        $apiKey = env('TOMTOM_API_KEY');
        $url = 'https://api.tomtom.com/search/2/search/' . urlencode($query) . '.json';

        $response =  Http::withOptions([
            'verify' => false, 
        ])->get($url,[
            'key'=> $apiKey,
            'limit'=> 6,
            'typeahead' => true,
            'language' => 'it-IT',
            'idxSet' => 'Str',
            'countrySet'=> 'IT'
        ]);

        $results = $response->json()['results'];

        $suggestions = array_map(function ($result) {
            return [
                'address' => $result['address']['freeformAddress'],
                'lat' => $result['position']['lat'],
                'lon' => $result['position']['lon']
            ];
        }, $results);

        return response()->json($suggestions);
    }
}
