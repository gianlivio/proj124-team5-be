<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Service;
use App\Models\Sponsorship;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::all();
        return view('admin.apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        $sponsorships = Sponsorship::all();
        return view('admin.apartments.create',compact('services', 'sponsorships'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $apartment = new Apartment();
        $apartment->fill($data);
        $apartment->slug = Str::slug($request->title);
        $apartment->save();

        return redirect()->route('admin.apartments.show', compact('apartment'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Apartment $apartment)
    {
        $services = Service::all();
        return view('admin.apartments.show', compact('apartment', 'services'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Apartment $apartment)
    {
        $apartments = Apartment::all();
        $services = Service::all();
        $sponsorships = Sponsorship::all();
        return view('admin.apartments.edit', compact('apartments', 'services', 'sponsorships'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Apartment $apartment)
    {
        $data = $request->validated();
        $apartment->slug = Str::slug($apartment->title);

        $apartment->update($data);
        return redirect()->route('admin.apartments.show', ['apartment' => $apartment->slug])->with('message', 'apartment ' . $apartment->title . '  è stato modificato');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Apartment $apartment)
    {
        // $apartment->sponsorships()->detach();
        // $apartment->services()->detach();
        $apartment->delete();
        return redirect()->route('admin.apartments.index')->with('message', 'apartment ' . $apartment->title . ' è stato cancellato');
    }
}
