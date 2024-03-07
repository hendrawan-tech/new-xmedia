<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\UserHasInstallationController;
use App\Http\Controllers\UserHasInvoiceController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('invoices/confirm', [InvoiceController::class, 'confirm']);
    Route::resource('invoices', InvoiceController::class);
    Route::resource('user/clients', ClientController::class);
    Route::get('user/employees/{id}/invoice', [UserHasInvoiceController::class, 'index']);
    Route::post('user/employees/{id}/invoice', [UserHasInvoiceController::class, 'store']);
    Route::get('user/employees/{id}/installation', [UserHasInstallationController::class, 'index']);
    Route::post('user/employees/{id}/installation', [UserHasInstallationController::class, 'store']);
    Route::resource('user/employees', EmployeeController::class);
    Route::resource('user/clients', ClientController::class);
    Route::resource('packages', PackageController::class);
    Route::resource('content/articles', ArticleController::class);
    Route::resource('content/promos', PromoController::class);
    Route::resource('content/notifications', NotificationController::class);
    Route::resource('payments', PaymentController::class);
});
