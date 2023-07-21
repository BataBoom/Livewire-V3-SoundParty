<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SpotifyController;


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

Route::get('/party/{partykey}', [SpotifyController::class, 'show'])->name('sound.party');
Route::get('/spotify', [SpotifyController::class, 'index']);
Route::get('/host', [SpotifyController::class, 'signup'])->name('sound.host');

Route::get('/auth/{provider}', [SpotifyController::class, 'redirectToProvider'])->name('provider-auth');
Route::get('/auth/{provider}/callback', [SpotifyController::class, 'handleProviderCallback']);
