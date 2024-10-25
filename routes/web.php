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
    return Route::post(env('LARAVEL_URL').'/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(env('LARAVEL_URL').'/livewire/livewire.js', $handle);
});

Route::get('/', function () {
    return view('welcome');
});


Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::get('/{id}', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::delete('/{id}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
    });
    Route::prefix('offices')->group(function () {
        Route::get('/offices', [AdminController::class, 'offices'])->name('admin.offices');
        Route::get('/offices/create', [AdminController::class, 'CreateOffice'])->name('admin.office.create');
        Route::get('/offices/{id}', [AdminController::class, 'EditOffice'])->name('admin.office.edit');
        Route::delete('/offices/{id}', [AdminController::class, 'DeleteOffice'])->name('admin.office.delete');
    });
    Route::prefix('products')->group(function () {
        Route::get('/', [AdminController::class, 'products'])->name('admin.products');
        Route::get('/{mission}/{living}', [AdminController::class, 'productsSpecific'])->name('admin.products.specific');
    });
    Route::get('/units', [AdminController::class, 'units'])->name('admin.units');

});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
