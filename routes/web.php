<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AvailableRoomController;

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
    return view('welcome');
});
Route::get('stripe', function () {
    return view('stripe');
});


Route::controller(AvailableRoomController::class)->group(function(){
    Route::post('stripe', 'stripePost')->name('stripe.post');
});

