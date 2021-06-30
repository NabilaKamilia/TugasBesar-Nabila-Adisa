<?php

use Illuminate\Htpp\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

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

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Route::resource('/cucian', CucianController::class);
//Route::get('/', [DashboardController::class, 'index']);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/dashboard/create', [DashboardController::class, 'create']);
Route::get('/dashboard/{dashboard}', [DashboardController::class, 'show']);
Route::post('/dashboard', [DashboardController::class, 'store']);
Route::delete('/{dashboard}', [DashboardController::class, 'destroy']);
Route::get('/{dashboard}/edit', [DashboardController::class, 'edit']);
Route::patch('/dashboard/{dashboard}', [DashboardController::class, 'update']);