<?php

use App\Http\Controllers\API\InvoiceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Invoice API Routes
|--------------------------------------------------------------------------
|
| Add these routes to your routes/api.php file
|
*/

Route::middleware('auth:sanctum')->prefix('invoices')->group(function () {
    Route::get('/', [InvoiceController::class, 'index']);
    Route::post('/', [InvoiceController::class, 'store']);
    Route::get('/{invoice}', [InvoiceController::class, 'show']);
    Route::put('/{invoice}', [InvoiceController::class, 'update']);
    Route::delete('/{invoice}', [InvoiceController::class, 'destroy']);
    Route::get('/{invoice}/pdf', [InvoiceController::class, 'generatePDF']);
    Route::get('/{invoice}/download', [InvoiceController::class, 'downloadPDF']);
    Route::patch('/{invoice}/status', [InvoiceController::class, 'updateStatus']);
});
