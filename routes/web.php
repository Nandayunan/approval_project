<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SupplierDashboardController;
use App\Http\Controllers\SecurityDashboardController;
use App\Http\Controllers\ExportImportDashboardController;
use App\Http\Controllers\WarehouseDashboardController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::middleware(['auth'])->group(function () {
    // Universal dashboard route
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Supplier Routes
    Route::middleware(['role:supplier'])->prefix('supplier')->name('supplier.')->group(function () {
        Route::get('dashboard', [SupplierDashboardController::class, 'index'])->name('dashboard');
        Route::get('packaging-forms', [SupplierDashboardController::class, 'packagingForms'])->name('packaging-forms');
        Route::get('packaging-forms/create', [SupplierDashboardController::class, 'packagingFormCreate'])->name('packaging-forms.create');
        Route::post('packaging-forms', [SupplierDashboardController::class, 'packagingFormStore'])->name('packaging-forms.store');

        Route::get('resin-forms', [SupplierDashboardController::class, 'resinForms'])->name('resin-forms');
        Route::get('resin-forms/create', [SupplierDashboardController::class, 'resinFormCreate'])->name('resin-forms.create');
        Route::post('resin-forms', [SupplierDashboardController::class, 'resinFormStore'])->name('resin-forms.store');

        Route::get('film-forms', [SupplierDashboardController::class, 'filmForms'])->name('film-forms');
        Route::get('film-forms/create', [SupplierDashboardController::class, 'filmFormCreate'])->name('film-forms.create');
        Route::post('film-forms', [SupplierDashboardController::class, 'filmFormStore'])->name('film-forms.store');
    });

    // Security Routes
    Route::middleware(['role:security'])->prefix('security')->name('security.')->group(function () {
        Route::get('dashboard', [SecurityDashboardController::class, 'index'])->name('dashboard');
        Route::get('pending-approvals', [SecurityDashboardController::class, 'pendingApprovals'])->name('pending-approvals');
        Route::get('view-form/{modelType}/{modelId}', [SecurityDashboardController::class, 'viewForm'])->name('view-form');
        Route::post('approve/{approvalId}', [SecurityDashboardController::class, 'approve'])->name('approve');
        Route::post('reject/{approvalId}', [SecurityDashboardController::class, 'reject'])->name('reject');
    });

    // Export-Import Routes
    Route::middleware(['role:export_import'])->prefix('export-import')->name('export_import.')->group(function () {
        Route::get('dashboard', [ExportImportDashboardController::class, 'index'])->name('dashboard');
        Route::get('pending-approvals', [ExportImportDashboardController::class, 'pendingApprovals'])->name('pending-approvals');
        Route::get('view-form/{modelType}/{modelId}', [ExportImportDashboardController::class, 'viewForm'])->name('view-form');
        Route::post('approve/{approvalId}', [ExportImportDashboardController::class, 'approve'])->name('approve');
        Route::post('reject/{approvalId}', [ExportImportDashboardController::class, 'reject'])->name('reject');
    });

    // Warehouse Routes
    Route::middleware(['role:warehouse'])->prefix('warehouse')->name('warehouse.')->group(function () {
        Route::get('dashboard', [WarehouseDashboardController::class, 'index'])->name('dashboard');
        Route::get('pending-approvals', [WarehouseDashboardController::class, 'pendingApprovals'])->name('pending-approvals');
        Route::get('approved-forms', [WarehouseDashboardController::class, 'approvedForms'])->name('approved-forms');
        Route::get('view-form/{modelType}/{modelId}', [WarehouseDashboardController::class, 'viewForm'])->name('view-form');
        Route::get('edit/{modelType}/{modelId}', [WarehouseDashboardController::class, 'edit'])->name('edit');
        Route::put('update/{modelType}/{modelId}', [WarehouseDashboardController::class, 'update'])->name('update');
        Route::delete('delete/{modelType}/{modelId}', [WarehouseDashboardController::class, 'delete'])->name('delete');
        Route::post('approve/{approvalId}', [WarehouseDashboardController::class, 'approve'])->name('approve');
        Route::post('reject/{approvalId}', [WarehouseDashboardController::class, 'reject'])->name('reject');
    });
});

require __DIR__ . '/auth.php';
