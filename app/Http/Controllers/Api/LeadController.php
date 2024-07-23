<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\NewContact;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller {
    public function store(Request $request) {
        $data = $request->all();
        $newLead = new Lead();
        $newLead->fill($data);
        // dd($request->apartment_id);
        $newLead->apartment_id = $request->apartment_id; 
        $newLead->save();
        // Invio email all'amministratore del sito
        Mail::to('info@boolbnb.com')->send(new NewContact($newLead));

        return response()->json([
            'success' => true
        ]);
    }
}
