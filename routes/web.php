<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\User\OrderController as UserOrderController;

// User Routes (Public)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/scan-instructions', [HomeController::class, 'scanInstructions'])->name('scan.instructions');
Route::get('/scan/{tableNumber}', [UserOrderController::class, 'scanTable'])->name('user.scan.table');
Route::post('/order', [UserOrderController::class, 'store'])->name('user.order.store');
Route::get('/order/{order}/confirmation', [UserOrderController::class, 'confirmation'])->name('user.order.confirmation');
Route::get('/order/{order}/receipt', [UserOrderController::class, 'receipt'])->name('user.order.receipt');
Route::get('/order/{order}/status', [UserOrderController::class, 'status'])->name('user.order.status');

// Admin Authentication Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Protected Admin Routes
    Route::middleware(['admin'])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Menu Management
        Route::resource('menus', MenuController::class);
        
        // Category Management
        Route::resource('categories', CategoryController::class)->except(['show']);
        
        // Table Management
        Route::resource('tables', TableController::class);
        
        // Table QR Code routes - inside admin middleware
        Route::post('tables/{table}/generate-barcode', [TableController::class, 'generateBarcode'])
            ->name('tables.generate-barcode');

        Route::post('tables/{table}/generate-barcode-with-logo', [TableController::class, 'generateBarcodeWithLogo'])
            ->name('tables.generate-barcode-with-logo');

        Route::get('tables/{table}/download-barcode', [TableController::class, 'downloadBarcode'])
            ->name('tables.download-barcode');

        // Bulk regenerate
        Route::post('tables/regenerate-all', [TableController::class, 'regenerateAll'])
            ->name('tables.regenerate-all');

        // Optional: debug info
        Route::get('tables/{table}/debug-barcode', [TableController::class, 'debugBarcode'])
            ->name('tables.debug-barcode');
            
        // Order Management
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
        Route::post('orders/{order}/quick-action', [OrderController::class, 'quickActions'])->name('orders.quick-action');
        Route::post('orders/bulk-update', [OrderController::class, 'bulkUpdateStatus'])->name('orders.bulk-update');
        
        // Receipt data for printing (NEW)
        Route::get('orders/{order}/receipt-data', [OrderController::class, 'getReceiptData'])->name('orders.receipt-data');
        
        // Payment Method Management
        Route::resource('payment-methods', PaymentMethodController::class);
        
        // Reports
        Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
        Route::get('reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');
    });
});