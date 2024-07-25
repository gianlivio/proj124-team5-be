<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\View;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function store(Request $request) {
        $view = new View();
        $view->user_ip = $request->ip();
        $view->user_id = $request->user_id;
        $view->title = $request->title;
        $view->apartment_id = $request->apartment_id;
        $view->save();

        return response()->json(['result' => 'visita registrata'], 201);
    }
}
