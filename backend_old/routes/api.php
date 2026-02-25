<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\ProductController;
use App\Http\Controllers\API\V1\TransactionController;
use App\Http\Controllers\API\V1\SyncController;
use App\Http\Controllers\API\V1\InventoryController;
use App\Http\Controllers\API\V1\CustomerController;
use App\Http\Controllers\API\V1\ReportController;
use App\Http\Controllers\API\V1\AdminBranchController;
use App\Http\Controllers\API\V1\AdminUserController;
use App\Http\Controllers\API\V1\AdminTerminalController;

Route::prefix('v1')->group(function () {

    Route::prefix('auth')->group(function () {
        Route::post('/terminal',        [AuthController::class, 'registerTerminal']);
        Route::post('/cashier/login',   [AuthController::class, 'cashierLogin']);
        Route::post('/cashier/logout',  [AuthController::class, 'cashierLogout'])
            ->middleware('auth:sanctum');
    });

    Route::get('/health', fn() => response()->json([
        'status'  => 'ok',
        'version' => config('app.version', '1.0.0'),
        'time'    => now()->toISOString(),
    ]));

    Route::middleware(['auth:sanctum', 'terminal.context'])->group(function () {

        Route::get('/products',                 [ProductController::class, 'index']);
        Route::get('/products/search',          [ProductController::class, 'search']);
        Route::get('/products/barcode/{barcode}', [ProductController::class, 'findByBarcode']);
        Route::get('/products/{product}',       [ProductController::class, 'show']);

        Route::post('/sync/batch',  [SyncController::class, 'batch']);
        Route::get('/sync/status',  [SyncController::class, 'status']);

        Route::get('/transactions',          [TransactionController::class, 'index']);
        Route::get('/transactions/{id}',     [TransactionController::class, 'show']);
        Route::post('/transactions/{id}/refund', [TransactionController::class, 'refund'])
            ->middleware('can:process-refunds');

        Route::get('/customers/search',            [CustomerController::class, 'search']);
        Route::get('/customers/{customer}',        [CustomerController::class, 'show']);
        Route::post('/customers',                  [CustomerController::class, 'store']);
        Route::put('/customers/{customer}',        [CustomerController::class, 'update']);
        Route::post('/customers/{customer}/loyalty/redeem', [CustomerController::class, 'redeemPoints']);

        Route::get('/inventory/{branchId}',    [InventoryController::class, 'levels']);
        Route::post('/inventory/transfer',     [InventoryController::class, 'transfer'])
            ->middleware('can:transfer-stock');
        Route::post('/inventory/purchase-order', [InventoryController::class, 'purchaseOrder'])
            ->middleware('can:manage-inventory');

        Route::middleware('can:view-reports')->group(function () {
            Route::get('/reports/daily',    [ReportController::class, 'daily']);
            Route::get('/reports/products', [ReportController::class, 'products']);
            Route::get('/reports/branches', [ReportController::class, 'branches']);
        });

        Route::prefix('admin')->middleware('can:admin-access')->group(function () {
            Route::apiResource('branches',  AdminBranchController::class);
            Route::apiResource('users',     AdminUserController::class);
            Route::get('terminals',         [AdminTerminalController::class, 'index']);
            Route::put('terminals/{id}',    [AdminTerminalController::class, 'update']);
            Route::delete('terminals/{id}', [AdminTerminalController::class, 'destroy']);
        });
    });
});