<?php

namespace App\Http\Controllers;

use App\Mail\NewContact;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class LeadController extends Controller
{
    public function store (Request $request) {
        $data = $request->all();

        $newLead = new Lead();
        $newLead->fill($data);
        $newLead->save();

        Mail::to('info@boolpress.com')->send(new NewContact($newLead));
        return response()->json([
            "results" => "success"
        ]);
    }
}
