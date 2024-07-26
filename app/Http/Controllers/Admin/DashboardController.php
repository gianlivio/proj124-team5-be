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

        // Subquery per ottenere solo le prime 5 visualizzazioni per user_ip per appartamento in ogni giorno
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

        // Query principale per ottenere le visualizzazioni mensili per ogni appartamento
        $viewsCountByApartment = DB::table(DB::raw("($subquery) as sub"))
            ->join('views', 'views.id', '=', 'sub.id')
            ->join('apartments', 'views.apartment_id', '=', 'apartments.id')
            ->select(
                'views.apartment_id',
                'apartments.title',
                DB::raw('YEAR(views.created_at) as year'),
                DB::raw('MONTH(views.created_at) as month'),
                DB::raw('count(*) as total_views')
            )
            ->where('apartments.user_id', $user->id)
            ->groupBy('views.apartment_id', 'year', 'month', 'apartments.title')
            ->orderBy('views.apartment_id')
            ->orderBy('year')
            ->orderBy('month')
            ->get()
            ->groupBy('apartment_id');

        // Query per ottenere il numero di lead per appartamento
        $apartmentLeads = Lead::select('apartment_id', DB::raw('count(*) as generated_leads'), 'apartments.title')
            ->leftJoin('apartments', 'leads.apartment_id', '=', 'apartments.id')
            ->where('apartments.user_id', $user->id)
            ->groupBy('leads.apartment_id', 'apartments.title')
            ->get();

        return view('admin.dashboard', [
            'viewsCountByApartment' => $viewsCountByApartment,
            'apartmentLeads' => $apartmentLeads
        ]);
    }
}
