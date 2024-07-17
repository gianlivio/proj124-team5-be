<?php

use App\Http\Controllers\Api\ApartmentController;
use App\Http\Controllers\Api\AutocompleteController;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/apartment/{slug}/address', [ApartmentController::class, 'getAddressFromCoordinates']);
Route::put('/apartments/{slug}/update-coordinates', [ApartmentController::class, 'updateCoordinates']);
Route::get('/autocomplete', [AutocompleteController::class, 'search'])->name('autocomplete.search');
Route::get('/apartments/search', [ApartmentController::class, "searchApartments"]);
Route::post('/apartments/send-location', [ApartmentController::class, 'searchInput']);
