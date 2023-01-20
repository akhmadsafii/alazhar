<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarcodeController;
use App\Http\Controllers\BrokenActionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ConsumableController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExterminateController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SourceController;
use App\Http\Controllers\StockOpnameController;
use App\Http\Controllers\StuffController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
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

Route::get('/', [DashboardController::class, 'user'])->middleware('auth:user');

Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login-verify', [AuthController::class, 'verify_login'])->name('verify_login');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('user')->name('user.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'user'])->name('dashboard');
    Route::get('statistic', [DashboardController::class, 'statistic_rental_chart'])->name('statistic');
    Route::get('rental-day', [DashboardController::class, 'rental_day'])->name('rental_day');

    Route::prefix('submissions')->name('submission.')->group(function () {
        Route::prefix('rentals')->name('rental.')->group(function () {
            Route::get('/', [RentalController::class, 'list_rental'])->name('list');
            Route::get('detail', [RentalController::class, 'detail_rental'])->name('detail');
            Route::post('save-user', [RentalController::class, 'save_user'])->name('save_user');
        });
        Route::prefix('procurements')->name('procurement.')->group(function () {
            Route::get('/', [ProcurementController::class, 'list_procurement'])->name('list');
            Route::get('detail', [ProcurementController::class, 'detail_rental'])->name('detail');
            Route::post('save-user', [ProcurementController::class, 'save_user'])->name('save_user');
        });
        Route::prefix('consumables')->name('consumable.')->group(function () {
            Route::get('/', [ConsumableController::class, 'list_consumable'])->name('list');
            Route::get('detail', [ConsumableController::class, 'detail_consumable'])->name('detail');
            Route::post('save-user', [ConsumableController::class, 'save_user'])->name('save_user');
        });
    });

    Route::prefix('histories')->name('history.')->group(function () {
        Route::get('rental', [HistoryController::class, 'rental'])->name('rental');
        Route::get('rental-detail', [RentalController::class, 'detail_complete'])->name('rental_detail');
        Route::get('procurement', [HistoryController::class, 'procurement'])->name('procurement');
        Route::get('procurement-detail', [ProcurementController::class, 'detail'])->name('procurement_detail');
        Route::get('consumable', [HistoryController::class, 'consumable'])->name('consumable');
        Route::get('consumable-detail', [ConsumableController::class, 'detail'])->name('consumable_detail');
    });

    Route::prefix('profiles')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'user'])->name('user');
        Route::post('update-user', [ProfileController::class, 'update_user'])->name('update_user');
        Route::post('update-password', [ProfileController::class, 'update_password'])->name('update_password');
    });
})->middleware('auth:user');

// Route::get('/', [DashboardController::class, 'admin'])->middleware('auth:user');
Route::middleware('auth:admin')->group(function () {
    Route::prefix('dashboard')->name('admin.')->group(function () {
        Route::get('/', [DashboardController::class, 'admin'])->name('dashboard');
        Route::get('statistic_chart', [DashboardController::class, 'statistic_chart'])->name('statistic');
        Route::get('not-back', [DashboardController::class, 'not_back'])->name('dashboard-not_back');
        Route::get('last-procurement', [DashboardController::class, 'last_procurement'])->name('dashboard-last_procurement');
    });
    Route::get('dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    Route::prefix('types')->name('type.')->group(function () {
        Route::get('/', [TypeController::class, 'index'])->name('home');
        Route::post('/', [TypeController::class, 'store'])->name('store');
        Route::get('detail', [TypeController::class, 'detail'])->name('detail');
        Route::get('delete', [TypeController::class, 'delete'])->name('delete');
        Route::get('template', [TypeController::class, 'template'])->name('template');
        Route::post('import', [TypeController::class, 'import'])->name('import');
    });

    Route::prefix('categories')->name('category.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('home');
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::get('detail', [CategoryController::class, 'detail'])->name('detail');
        Route::get('by-type', [CategoryController::class, 'by_type'])->name('by_type');
        Route::get('type-category', [CategoryController::class, 'type_select'])->name('type_category-by_select');
        Route::get('delete', [CategoryController::class, 'delete'])->name('delete');
        Route::get('template', [CategoryController::class, 'template'])->name('template');
        Route::post('import', [CategoryController::class, 'import'])->name('import');
    });

    Route::prefix('schools')->name('school.')->group(function () {
        Route::get('/', [SchoolController::class, 'index'])->name('home');
        Route::post('/', [SchoolController::class, 'store'])->name('store');
    });

    Route::prefix('units')->name('unit.')->group(function () {
        Route::get('/', [UnitController::class, 'index'])->name('home');
        Route::post('/', [UnitController::class, 'store'])->name('store');
        Route::get('detail', [UnitController::class, 'detail'])->name('detail');
        Route::get('delete', [UnitController::class, 'delete'])->name('delete');
        Route::get('template', [UnitController::class, 'template'])->name('template');
        Route::post('import', [UnitController::class, 'import'])->name('import');
    });

    Route::prefix('locations')->name('location.')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('home');
        Route::post('/', [LocationController::class, 'store'])->name('store');
        Route::get('detail', [LocationController::class, 'detail'])->name('detail');
        Route::get('delete', [LocationController::class, 'delete'])->name('delete');
        Route::get('template', [LocationController::class, 'template'])->name('template');
        Route::post('import', [LocationController::class, 'import'])->name('import');
    });

    Route::prefix('suppliers')->name('supplier.')->group(function () {
        Route::get('/', [SupplierController::class, 'index'])->name('home');
        Route::post('/', [SupplierController::class, 'store'])->name('store');
        Route::get('detail', [SupplierController::class, 'detail'])->name('detail');
        Route::get('delete', [SupplierController::class, 'delete'])->name('delete');
        Route::get('template', [SupplierController::class, 'template'])->name('template');
        Route::post('import', [SupplierController::class, 'import'])->name('import');
    });

    Route::prefix('broken-actions')->name('broken_action.')->group(function () {
        Route::get('/', [BrokenActionController::class, 'index'])->name('home');
        Route::post('/', [BrokenActionController::class, 'store'])->name('store');
        Route::get('detail', [BrokenActionController::class, 'detail'])->name('detail');
        Route::get('delete', [BrokenActionController::class, 'delete'])->name('delete');
    });

    Route::prefix('sources')->name('source.')->group(function () {
        Route::get('/', [SourceController::class, 'index'])->name('home');
        Route::post('/', [SourceController::class, 'store'])->name('store');
        Route::get('detail', [SourceController::class, 'detail'])->name('detail');
        Route::get('delete', [SourceController::class, 'delete'])->name('delete');
    });

    Route::prefix('stuffs')->name('stuff.')->group(function () {
        Route::get('/', [StuffController::class, 'index'])->name('home');
        Route::post('/', [StuffController::class, 'store'])->name('store');
        Route::get('information', [StuffController::class, 'info'])->name('information');
        Route::get('detail', [StuffController::class, 'detail'])->name('detail');
        Route::get('delete', [StuffController::class, 'delete'])->name('delete');
        Route::get('template', [StuffController::class, 'template'])->name('template');
        Route::post('import', [StuffController::class, 'import'])->name('import');
    });

    Route::prefix('items')->name('item.')->group(function () {
        Route::get('/', [ItemController::class, 'index'])->name('home');
        Route::post('/', [ItemController::class, 'store'])->name('store');
        Route::get('detail', [ItemController::class, 'detail'])->name('detail');
        Route::get('stuff', [ItemController::class, 'stuff'])->name('by_stuff');
        Route::get('load-stuff', [ItemController::class, 'load_stuff'])->name('load_item_stuff');
        Route::get('delete', [ItemController::class, 'delete'])->name('delete');
        Route::get('location-item', [ItemController::class, 'location_item'])->name('location_item');
        Route::get('location-stuff', [ItemController::class, 'location_stuff'])->name('datatable_location_stuff');
        Route::get('template', [ItemController::class, 'template'])->name('template');
        Route::post('import', [ItemController::class, 'import'])->name('import');
    });

    Route::prefix('procurements')->name('procurement.')->group(function () {
        Route::get('/', [ProcurementController::class, 'index'])->name('home');
        Route::post('/', [ProcurementController::class, 'store'])->name('store');
        Route::get('detail', [ProcurementController::class, 'detail'])->name('detail');
        Route::get('delete', [ProcurementController::class, 'delete'])->name('delete');
        Route::get('update-status', [ProcurementController::class, 'update_status'])->name('update_status');
    });

    Route::prefix('exterminations')->name('exterminate.')->group(function () {
        Route::get('/', [ExterminateController::class, 'index'])->name('home');
        Route::post('/', [ExterminateController::class, 'store'])->name('store');
        Route::get('detail', [ExterminateController::class, 'detail'])->name('detail');
        Route::get('detail-complete', [ExterminateController::class, 'detail_complete'])->name('detail_complete');
        Route::post('update', [ExterminateController::class, 'update'])->name('update');
        Route::get('delete', [ExterminateController::class, 'delete'])->name('delete');
        Route::get('update-status', [ExterminateController::class, 'update_status'])->name('update_status');
    });

    Route::prefix('rentals')->name('rental.')->group(function () {
        Route::get('/', [RentalController::class, 'index'])->name('home');
        Route::post('/', [RentalController::class, 'store'])->name('store');
        Route::post('update', [RentalController::class, 'update'])->name('update');
        Route::get('detail', [RentalController::class, 'detail'])->name('detail');
        Route::get('detail-complete', [RentalController::class, 'detail_complete'])->name('detail_complete');
        Route::post('confirm-return', [RentalController::class, 'confirm_date'])->name('confirm-returned_date');
        Route::get('data-item', [RentalController::class, 'data_item'])->name('data_item');
        Route::get('update-status', [RentalController::class, 'update_status'])->name('update_status');
        Route::get('delete', [RentalController::class, 'delete'])->name('delete');
    });

    Route::prefix('stock-bhp')->name('stock_bhp.')->group(function () {
        Route::get('/', [ConsumableController::class, 'stock_bhp'])->name('home');
    });

    Route::prefix('consumables')->name('consumable.')->group(function () {
        Route::get('/', [ConsumableController::class, 'index'])->name('home');
        Route::post('/', [ConsumableController::class, 'store'])->name('store');
        Route::get('detail', [ConsumableController::class, 'detail'])->name('detail');
        Route::get('update-status', [ConsumableController::class, 'update_status'])->name('update_status');
        Route::get('delete', [ConsumableController::class, 'delete'])->name('delete');
        Route::get('data-stuff', [ConsumableController::class, 'data_stuff'])->name('data_stuff');
    });

    Route::prefix('opnames')->name('opname.')->group(function () {
        Route::get('/', [StockOpnameController::class, 'index'])->name('home');
        Route::post('/', [StockOpnameController::class, 'store'])->name('store');
        Route::get('detail', [StockOpnameController::class, 'detail'])->name('detail');
    });

    Route::prefix('reports')->name('report.')->group(function () {
        Route::get('stuff', [ReportController::class, 'stuff'])->name('stuff');
        Route::get('item', [ReportController::class, 'item'])->name('item');
        Route::get('consumable', [ReportController::class, 'consumable'])->name('consumable');
        Route::get('rental', [ReportController::class, 'rental'])->name('rental');
        Route::get('procurement', [ReportController::class, 'procurement'])->name('procurement');
        Route::get('extermination', [ReportController::class, 'extermination'])->name('extermination');
    });

    Route::prefix('barcodes')->name('barcode.')->group(function () {
        Route::get('/', [BarcodeController::class, 'index'])->name('home');
        Route::get('print', [BarcodeController::class, 'print'])->name('print');
    });

    Route::prefix('users')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('home');
        Route::get('option', [UserController::class, 'option'])->name('option');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('detail', [UserController::class, 'detail'])->name('detail');
        Route::get('delete', [UserController::class, 'delete'])->name('delete');
    });

    Route::prefix('admins')->name('admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('home');
        Route::post('/', [AdminController::class, 'store'])->name('store');
        Route::get('detail', [AdminController::class, 'detail'])->name('detail');
        Route::get('delete', [AdminController::class, 'delete'])->name('delete');
    });

    Route::prefix('profiles')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'admin'])->name('admin');
        Route::post('update', [ProfileController::class, 'update_profile'])->name('update');
        Route::post('update-password', [ProfileController::class, 'update_password'])->name('update_password');
    });
});
