<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $apartmentIds = $user->apartments()->pluck("id");

        $leads = Lead::whereIn('apartment_id', $apartmentIds)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.leads.index', compact('leads'));
    }



    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        return view('admin.leads.show', compact('lead'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        // $lead->replied = $request->replied;
        // $lead->save();

        $lead = Lead::find($lead->id);
        $lead->replied = $request->has('replied') ? 1 : 0;
        $lead->save();
        
        return redirect()->route('admin.leads.index')->with('success', 'Hai cambiato lo stato del messaggio con successo.');;
    }
}
