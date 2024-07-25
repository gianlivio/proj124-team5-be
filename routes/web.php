<?php

use App\Http\Controllers\Admin\ApartmentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\SponsorshipController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')
    ->prefix('admin') // Prefisso nell'url delle rotte di questo gruppo
    ->name('admin.') // inizio di ogni nome delle rotte del gruppo
    ->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('apartments', ApartmentController::class)->parameters(['apartments'=>'apartment:slug']);

        // Rotta personalizzata per list_sponsor
        Route::get('/sponsorship', [ApartmentController::class, 'sponsorship_menu'])->name("sponsorship");
        Route::get('/apartment/{slug}/sponsor', [ApartmentController::class, 'showSponsorshipPage'])->name('apartment.sponsor');
        Route::post('/sponsorship', [SponsorshipController::class, 'store'])->name('sponsorship.store');
        Route::resource('/leads', LeadController::class)->except(['create', 'store', 'edit']);
    });

require __DIR__ . '/auth.php';
