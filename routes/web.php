<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/get/airport', [App\Http\Controllers\AirportController::class, 'index'])->name('getAirport');
Route::post('/create/airport', [App\Http\Controllers\AirportController::class, 'store'])->name('createAirport');
Route::post('/update/airport', [App\Http\Controllers\AirportController::class, 'update'])->name('updateAirport');
Route::post('/delete/airport', [App\Http\Controllers\AirportController::class, 'destroy'])->name('deleteAirport');

Route::get('/get/airline', [App\Http\Controllers\AirlineController::class, 'index'])->name('getAirline');
Route::post('/create/airline', [App\Http\Controllers\AirlineController::class, 'store'])->name('createAirline');
Route::post('/update/airline', [App\Http\Controllers\AirlineController::class, 'update'])->name('updateAirline');
Route::post('/delete/airline', [App\Http\Controllers\AirlineController::class, 'destroy'])->name('deleteAirline');

Route::get('/get/flight', [App\Http\Controllers\FlightController::class, 'index'])->name('getFlight');
Route::post('/create/flight', [App\Http\Controllers\FlightController::class, 'store'])->name('createFlight');
Route::post('/update/flight', [App\Http\Controllers\FlightController::class, 'update'])->name('updateFlight');
Route::post('/delete/flight', [App\Http\Controllers\FlightController::class, 'destroy'])->name('deleteFlight');