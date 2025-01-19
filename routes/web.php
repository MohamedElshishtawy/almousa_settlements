<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DryFoodReportController;
use App\Obligations\ObligationsController;
use App\Office\OfficeController;
use App\Report\ReportController;
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
    return view('auth.login');
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
        Route::get('/offices', [OfficeController::class, 'offices'])->name('admin.offices');
        Route::get('/offices/create', [OfficeController::class, 'CreateOffice'])->name('admin.office.create');
        Route::get('/offices/{id}', [OfficeController::class, 'EditOffice'])->name('admin.office.edit');
        Route::delete('/offices/{id}', [OfficeController::class, 'DeleteOffice'])->name('admin.office.delete');
    });
    Route::prefix('products')->group(function () {
        Route::get('/', [AdminController::class, 'products'])->name('admin.products');
        Route::get('/all', [AdminController::class, 'all'])->name('admin.products.all');
        Route::get('/{mission}/{living}', [AdminController::class, 'productsSpecific'])
            ->name('admin.products.specific');
    });
    Route::prefix('analytics')->group(function () {
       Route::get('/imports/{showPrices?}', [ReportController::class, 'AnalyticsImport'])->name('admin.analytics.imports');
       Route::get('/surplus/{showPrices?}', [ReportController::class, 'AnalyticsSurplus'])->name('admin.analytics.surplus');
       Route::get('/benefits/', [ReportController::class, 'AnalyticsBenefits'])->name('admin.analytics.benefits');
    });
    // Companies prefix
    Route::prefix('companies')->group(function () {
        Route::get('/', [CompanyController::class, 'companies'])->name('admin.companies');
    });

    Route::get('/units', [AdminController::class, 'units'])->name('admin.units');
    Route::get('/dates', [\App\Http\Controllers\HijriDateController::class, 'index'])->name('admin.dates');
    Route::get('/delegates', [\App\Http\Controllers\DelegateController::class, 'index'])->name('admin.delegates');

});

Route::prefix('managers')->middleware(['auth'])->group(function () {
    Route::get('/reports', [ReportController::class, 'reports'])->name('managers.reports');
    Route::get('/reports/import/{officeMission}/{date}', [ReportController::class, 'import'])
        ->name('managers.reports.import');
    Route::get('/reports/import/{office}/{date}/print', [ReportController::class, 'importPrint'])
        ->name('managers.reports.import.print');
    Route::get('/reports/import/{office}/{date}/print-writing', [ReportController::class, 'importPrintWriting'])
        ->name('managers.reports.import.print-writing');
    Route::get('/reports/surplus/print/{officeMission}/{date}/{meal?}', [ReportController::class, 'surplusPrint'])
        ->name('managers.reports.surplus.print');
    Route::get('/reports/surplus/{officeMission}/{date}/{meal?}', [ReportController::class, 'surplus'])
        ->name('managers.reports.surplus');
    Route::prefix('/dry-food-reports')->group(function () {
        Route::get('/', [DryFoodReportController::class, 'index'])->name('dry-food-reports');
        Route::get('/create', [DryFoodReportController::class, 'create'])->name('dry-food-reports.create');
        Route::get('/{dryFoodReport}/edit', [DryFoodReportController::class, 'edit'])->name('dry-food-reports.edit');
        Route::get('/{dryFoodReport}/show', [DryFoodReportController::class, 'print'])->name('dry-food-reports.print');
        Route::get('/{dryFoodReport}/delegate-report', [DryFoodReportController::class, 'delegateReport'])->name('dry-food-reports.delegateReport');
        Route::delete('/{dryFoodReport}', [DryFoodReportController::class, 'delete'])->name('dry-food-reports.destroy');
    });
    Route::prefix('/obligations')->group(function () {
        Route::get('/', [ObligationsController::class, 'index'])->name('obligations');
        Route::get('/create', [ObligationsController::class, 'create'])->name('obligations.create');
        Route::get('/{obligation}/edit', [ObligationsController::class, 'edit'])->name('obligations.edit');
        Route::get('/{obligations}/print-page', [ObligationsController::class, 'printPage'])->name('obligations.print');
        Route::delete('/{obligation}', [ObligationsController::class, 'delete'])->name('obligations.destroy');
    });
    Route::get('/papers/delegate-does-not-want', [\App\Models\Delegate::class, 'deosNotWant'])->name('papers.doesNotWant');

});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
