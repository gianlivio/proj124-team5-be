<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    $viewsCountByApartment = View::select('apartment_id','title', DB::raw('count(*) as total_views'))
        ->groupBy('apartment_id','title')
        ->where('user_id', $user->id)
        ->get();
    // dd($viewsCountByApartment);
    return view('admin.dashboard', ['viewsCountByApartment' => $viewsCountByApartment]);
}

}
