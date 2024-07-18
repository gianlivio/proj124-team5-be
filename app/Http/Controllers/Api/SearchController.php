<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\Apartment;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function storeInput(Request $request)
    {
        $input = $request->input('input');
        
        // Process the input as needed
        return response()->json(['message' => 'Input received successfully', 'input' => $input]);
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

        //ciao test
    }

    // public function searchInput (Request $request) {

    //     // non funzionava perche:
    //     //1) serve il prefisso api/ (errore 404)
    //     //2) import scorretto di Request: Illuminate\Support\Facades\Request; (errore 500)
    //     $location = $request->all();
    //     dd($location);
    // }

   
}
