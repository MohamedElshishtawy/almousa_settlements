<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use Livewire\Livewire;

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
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(env('ASSET_URL').'livewire/update', $handle);
});
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(env('ASSET_URL').'livewire/update', $handle);
});

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
