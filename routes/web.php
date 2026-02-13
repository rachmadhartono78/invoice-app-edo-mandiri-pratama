<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class , 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class , 'login']);
Route::get('/register', [AuthController::class , 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class , 'register']);
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\InvoiceController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class , 'index'])->name('dashboard');
    Route::get('/invoice/print', [InvoiceController::class , 'printPage'])->name('invoices.print_page');
    Route::get('/invoice/{id}/print-pdf', [InvoiceController::class , 'printPDF'])->name('invoices.print_pdf');
    Route::get('/invoices/{invoice}/print', [InvoiceController::class , 'print'])->name('invoices.print');
    Route::get('/invoices/{invoice}/preview', [InvoiceController::class , 'preview'])->name('invoices.preview');
    Route::get('/invoices/{invoice}/stream-pdf', [InvoiceController::class , 'streamPdf'])->name('invoices.stream_pdf');
    Route::resource('invoices', InvoiceController::class);

    // Products CRUD
    Route::resource('products', \App\Http\Controllers\Web\ProductController::class);

    // Clients CRUD
    Route::resource('clients', \App\Http\Controllers\Web\ClientController::class);

    Route::get('/settings', function () {
            return redirect('/dashboard'); // Placeholder
        }
        );
    });
