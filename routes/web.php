<?php

use App\DelegateAbcence\DelegateAbsenceController;
use App\Employment\EmploymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BreakFastProductController;
use App\Http\Controllers\BreakFastReportController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DelegateController;
use App\Http\Controllers\DryFoodReportController;
use App\Http\Controllers\HijriDateController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserEvaluateController;
use App\Http\Controllers\WhatsAppController;
use App\Obligations\ObligationsController;
use App\Office\OfficeController;
use App\Report\ReportController;
use App\Task\TaskController;
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

Route::get('create', function () {
    $r = ['evaluation_create', 'evaluation_edit', 'evaluation_delete', 'evaluation_print'];
    foreach ($r as $role) {
        \Spatie\Permission\Models\Permission::create(['name' => $role]);
    }
});

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/send-whatsapp', [WhatsAppController::class, 'sendWhatsAppMessage']);


Route::get('/', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth');

Route::middleware('auth')->group(function () {

    Route::get('permission-management', [AdminController::class, 'permissionManagement'])
        ->name('admin.permission-management')->middleware('role:admin');

    Route::prefix('users')->middleware('permission:users_management')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('admin.users');
        Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
        Route::get('/{user}', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::delete('/{user}', [UserController::class, 'delete'])->name('admin.users.delete');
    });

    Route::prefix('offices')->middleware('can:offices_management')->group(function () {
        Route::get('/', [OfficeController::class, 'offices'])->name('admin.offices');
        Route::get('/create', [OfficeController::class, 'CreateOffice'])->name('admin.office.create');
        Route::get('/{id}', [OfficeController::class, 'EditOffice'])->name('admin.office.edit');
        Route::delete('/{id}', [OfficeController::class, 'DeleteOffice'])->name('admin.office.delete');
    });

    Route::prefix('products')->middleware('permission:manage_all_products|manage_mission_products|break_fast_products_manage')->group(function (
    ) {
        Route::get('/', [AdminController::class, 'products'])->name('admin.products');
        Route::get('/all',
            [AdminController::class, 'all'])->name('admin.products.all')->middleware('permission:manage_all_products');
        Route::get('/{mission}/{living}', [
            AdminController::class, 'productsSpecific'
        ])->name('admin.products.specific')->middleware('permission:manage_mission_products');
        Route::get('/breakfast-products', [
            BreakFastProductController::class, 'index'
        ])->name('admin.breakfast-products')->middleware('permission:break_fast_products_manage');
    });

    Route::prefix('employment')->middleware('permission:employment_create|employment_edit|employment_delete')->group(function (
    ) {
        Route::get('/', [EmploymentController::class, 'employment'])->name('admin.employment');
    });

    Route::prefix('evaluate')->middleware('permission:evaluation_create|evaluation_edit|evaluation_delete')->group(function (
    ) {
        Route::get('/', [UserEvaluateController::class, 'index'])->name('admin.evaluate.index');
        Route::get('/manage', [UserEvaluateController::class, 'manage'])->name('admin.evaluate.manager');
        Route::get('/manage/{user}', [UserEvaluateController::class, 'manage'])->name('admin.evaluate.manager.');
        Route::get('/{user}', [UserEvaluateController::class, 'evaluate'])->name('admin.evaluate.user');
    });

    Route::prefix('analytics')->group(function () {
        Route::get('/imports/{showPrices?}', [
            ReportController::class, 'AnalyticsImport'
        ])->name('admin.analytics.imports')->middleware('permission:import_model2_create');
        Route::get('/surplus/{showPrices?}', [
            ReportController::class, 'AnalyticsSurplus'
        ])->name('admin.analytics.surplus')->middleware('permission:surplus_model2_create');
        Route::get('/benefits/', [
            ReportController::class, 'AnalyticsBenefits'
        ])->name('admin.analytics.benefits')->middleware('permission:beneficiaries_report_manage');
    });

    Route::prefix('companies')->group(function () {
        Route::get('/', [
            CompanyController::class, 'companies'
        ])->name('admin.companies')->middleware('permission:manage_companies');
    });


    Route::get('/units',
        [AdminController::class, 'units'])->name('admin.units')->middleware('permission:unites_management');
    Route::get('/dates',
        [HijriDateController::class, 'index'])->name('admin.dates')->middleware('permission:manage_dates');

    Route::prefix('tasks')->middleware('permission:tasks_create|tasks_edit|tasks_delete')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('admin.tasks');
        Route::get('/{officeId}', [TaskController::class, 'officeTasks'])->name('admin.tasks.office');
        Route::post('/{officeId}/store',
            [TaskController::class, 'storeTask'])->name('admin.tasks.store')->middleware('permission:tasks_create');
        Route::get('/{officeId?}/show', [TaskController::class, 'show'])->name('admin.tasks.managers');

    });


    Route::prefix('/delegates')->middleware('permission:delegate_create|delegate_edit|delegate_delete')->group(function (
    ) {
        Route::get('/', [DelegateController::class, 'index'])->name('admin.delegates');
        Route::get('/create', [
            DelegateController::class, 'create'
        ])->name('admin.delegates.create')->middleware('permission:delegate_create');
        Route::get('/{delegate}',
            [DelegateController::class, 'edit'])->name('admin.delegates.edit')->middleware('permission:delegate_edit');
        Route::delete('/{delegate}', [
            DelegateController::class, 'delete'
        ])->name('admin.delegates.delete')->middleware('permission:delegate_delete');
    });

    Route::prefix('breakfast')->middleware('permission:break_fast_create|break_fast_edit|break_fast_delete|break_fast_print')->group(function (
    ) {
        Route::get('/', [BreakFastReportController::class, 'index'])
            ->name('breakfast.index');
        Route::get('/create', [BreakFastReportController::class, 'create'])
            ->name('breakfast.create')->middleware('permission:break_fast_create');
        Route::post('/', [BreakFastReportController::class, 'store'])
            ->name('breakfast.store')->middleware('permission:break_fast_create');
        Route::get('/{breakfast}/edit', [BreakFastReportController::class, 'edit'])
            ->name('breakfast.edit')->middleware('permission:break_fast_edit');
        Route::put('/{breakfast}', [BreakFastReportController::class, 'update'])
            ->name('breakfast.update')->middleware('permission:break_fast_edit');
        Route::delete('/{breakfast}', [BreakFastReportController::class, 'destroy'])
            ->name('breakfast.destroy')->middleware('permission:break_fast_delete');
        Route::get('/{breakfast}/print', [BreakFastReportController::class, 'print'])
            ->name('breakfast.print')->middleware('permission:break_fast_print');
    });

    Route::get('/breakfast/{breakFastReport}/print', [BreakFastReportController::class, 'print'])
        ->name('breakfast.print')->middleware('permission:break_fast_print');

    Route::prefix('/reports')->middleware('permission:import_create|import_edit|import_delete|import_print|surplus_create|surplus_edit|surplus_delete|surplus_print')->group(function (
    ) {
        Route::get('/', [ReportController::class, 'reports'])->name('managers.reports');
        Route::prefix('/import')->group(function () {
            Route::get('/{officeMission}/{date}', [
                ReportController::class, 'import'
            ])->name('managers.reports.import')->middleware('permission:import_create|import_edit|import_delete|import_print|import_writing_print');
            Route::get('/{office}/{date}/print',
                [
                    ReportController::class, 'importPrint'
                ])->name('managers.reports.import.print')->middleware('permission:import_print');
            Route::get('/{office}/{date}/print-writing',
                [ReportController::class, 'importPrintWriting'])->name('managers.reports.import.print-writing');
        });
        Route::prefix('/surplus')->group(function () {
            Route::get('/print/{officeMission}/{date}/{meal?}',
                [
                    ReportController::class, 'surplusPrint'
                ])->name('managers.reports.surplus.print')->middleware('permission:surplus_print');
            Route::get('/{officeMission}/{date}/{meal?}',
                [
                    ReportController::class, 'surplus'
                ])->name('managers.reports.surplus')->middleware('permission:surplus_create|surplus_edit|surplus_delete');
        });
    });

    Route::prefix('/obligations')->middleware('permission:obligations_create|obligations_edit|obligations_delete|obligations_print')->group(function (
    ) {
        Route::get('/', [ObligationsController::class, 'index'])->name('obligations');
        Route::get('/create', [
            ObligationsController::class, 'create'
        ])->name('obligations.create')->middleware('permission:obligations_create');
        Route::get('/{obligation}/edit', [
            ObligationsController::class, 'edit'
        ])->name('obligations.edit')->middleware('permission:obligations_edit');
        Route::get('/{obligations}/print-page', [
            ObligationsController::class, 'printPage'
        ])->name('obligations.print')->middleware('permission:obligations_print');
        Route::delete('/{obligation}', [
            ObligationsController::class, 'delete'
        ])->name('obligations.destroy')->middleware('permission:obligations_delete');
    });

    Route::prefix('employment-form/{import}')->middleware('permission:employment_create|employment_edit|employment_delete')->group(function (
    ) {
        Route::get('/', [EmploymentController::class, 'employmentForm'])
            ->name('managers.employment');
        Route::get('/print', [EmploymentController::class, 'employmentFormPrint'])
            ->name('managers.employment.print')->middleware('permission:employment_print');
    });


    Route::get('/papers/delegate-rejects',
        [
            \App\Models\Delegate::class, 'rejects'
        ])->name('papers.doesNotWant')->middleware('permission:delegate_rejects_management');

    Route::prefix('delegate-abcence')->middleware('permission:delegate_absence_create|delegate_absence_edit|delegate_absence_delete|delegate_absence_print')->group(function (
    ) {
        Route::get('/', [DelegateAbsenceController::class, 'index'])->name('delegate-absence');
        Route::get('/{delegateAbcence}',
            [
                DelegateAbsenceController::class, 'printPage'
            ])->name('delegate-absence.print')->middleware('permission:delegate_absence_print');
    });


    Route::middleware('permission:dry_food_create|dry_food_edit|dry_food_delete|dry_food_print')->group(function () {
        Route::prefix('/dry-food-reports')->group(function () {
            Route::get('/', [DryFoodReportController::class, 'index'])->name('dry-food-reports');
            Route::get('/create', [
                DryFoodReportController::class, 'create'
            ])->name('dry-food-reports.create')->middleware('permission:dry_food_create');
            Route::get('/{dryFoodReport}/edit',
                [
                    DryFoodReportController::class, 'edit'
                ])->name('dry-food-reports.edit')->middleware('permission:dry_food_edit');
            Route::get('/{dryFoodReport}/show',
                [
                    DryFoodReportController::class, 'print'
                ])->name('dry-food-reports.print')->middleware('permission:dry_food_print');
            Route::get('/{dryFoodReport}/delegate-report',
                [
                    DryFoodReportController::class, 'delegateReport'
                ])->name('dry-food-reports.delegateReport')->middleware('permission:confirm_dry_food_reception');
            Route::delete('/{dryFoodReport}',
                [
                    DryFoodReportController::class, 'delete'
                ])->name('dry-food-reports.destroy')->middleware('permission:dry_food_delete');
        });

    });

});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
