<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\Lead;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
public function index()
{
    $user = Auth::user();

    $totalViews = View::where('user_id', $user->id)->count();
    // $viewsCountByApartment = View::select('apartment_id','title', DB::raw('count(*) as total_views'))
    //     ->groupBy('apartment_id','title')
    //     ->where('user_id', $user->id)
    //     ->get();

    $apartmentLeads = Lead::select('apartment_id', DB::raw('count(*) as generated_leads'), 'apartments.title')
    ->leftJoin('apartments', 'leads.apartment_id', '=', 'apartments.id') // Join con la tabella Apartment
    ->groupBy('leads.apartment_id', 'apartments.title')
    ->where('apartments.user_id', $user->id)
    ->get();


    $viewsCountByApartment = View::select('apartment_id', DB::raw('count(*) as total_views'), 'apartments.title')
    ->leftJoin('apartments', 'views.apartment_id', '=', 'apartments.id') // Join con la tabella Apartment
    ->groupBy('views.apartment_id', 'apartments.title')
    ->where('views.user_id', $user->id)
    ->get();

    return view('admin.dashboard', 
    ['viewsCountByApartment' => $viewsCountByApartment], 
    ['apartmentLeads' => $apartmentLeads]);
}

}
