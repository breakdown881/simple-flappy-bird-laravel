<?php

use App\Http\Controllers\GameController;
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

Route::post('/scores', [GameController::class, 'store']);
Route::get('/scores', [GameController::class, 'index']);
Route::view('/game', 'game');
Route::view('/', 'welcome');
