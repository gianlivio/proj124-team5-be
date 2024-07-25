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

        $apartmentLeads = Lead::select('apartment_id', DB::raw('count(*) as generated_leads'), 'apartments.title')
            ->leftJoin('apartments', 'leads.apartment_id', '=', 'apartments.id')
            ->groupBy('leads.apartment_id', 'apartments.title')
            ->where('apartments.user_id', $user->id)
            ->get();


        // $viewsCountByApartment = View::select('apartment_id', DB::raw('count(*) as total_views'), 'apartments.title')
        // ->leftJoin('apartments', 'views.apartment_id', '=', 'apartments.id')
        // ->groupBy('views.apartment_id', 'apartments.title')
        // ->where('views.user_id', $user->id)
        // ->get();

        $subquery = DB::table('views as v1')
            ->select('v1.id', 'v1.apartment_id', 'v1.user_ip', 'v1.created_at')
            ->whereRaw('(
        SELECT COUNT(*) 
        FROM views as v2 
        WHERE v2.apartment_id = v1.apartment_id 
        AND DATE(v2.created_at) = DATE(v1.created_at) 
        AND v2.user_ip = v1.user_ip 
        AND v2.created_at <= v1.created_at
    ) <= 5')
            ->toSql();

        // Query principale
        $viewsCountByApartment = DB::table(DB::raw("($subquery) as sub"))
            ->join('views', 'views.id', '=', 'sub.id')
            ->join('apartments', 'views.apartment_id', '=', 'apartments.id')
            ->select('views.apartment_id', DB::raw('count(*) as total_views'), 'apartments.title')
            ->where('apartments.user_id', $user->id)
            ->groupBy('views.apartment_id', 'apartments.title')
            ->get();

        return view(
            'admin.dashboard',
            ['viewsCountByApartment' => $viewsCountByApartment],
            ['apartmentLeads' => $apartmentLeads]
        );
    }
}
