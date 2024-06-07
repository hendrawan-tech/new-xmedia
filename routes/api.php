<?php

use App\Http\Controllers\Api\InvoiceController;
use App\Http\Controllers\Api\AppController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DataController;
use App\Http\Controllers\Api\InstallationController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum'])->group(function () {
    // User
    Route::get('/user', [UserController::class, 'user']);
    Route::get('/users', [UserController::class, 'getUser']);
    Route::post('/user', [UserController::class, 'createUser']);
    Route::put('/user', [UserController::class, 'updateUser']);
    Route::post('/user/change-password', [UserController::class, 'changePassword']);

    // Installation
    Route::post('/installation', [InstallationController::class, 'installation']);
    Route::get('/installation', [InstallationController::class, 'listInstallation']);
    Route::post('/installation/update', [InstallationController::class, 'updateInstallation']);
    Route::post('/installation/proccess', [InstallationController::class, 'proccessInstallation']);

    // Invoice
    // Route::post('/invoice/create', [InvoiceController::class, 'createInvoice']);
    Route::post('/invoice/offline', [InvoiceController::class, 'paymentOffline']);
    Route::post('/invoice/transfer', [InvoiceController::class, 'paymentTransfer']);
    // Route::post('/invoice/xendit', [InvoiceController::class, 'paymentXendit']);
    Route::get('/invoices', [InvoiceController::class, 'listInvoice']);
    Route::get('/invoice', [InvoiceController::class, 'myInvoice']);
    Route::get('/payments', [InvoiceController::class, 'listPayment']);
    Route::post('/invoice/status', [InvoiceController::class, 'checkStatus']);

    // App
    Route::get('/promo', [AppController::class, 'promo']);
    Route::get('/article', [AppController::class, 'article']);
    Route::get('/about', [AppController::class, 'about']);

    Route::get('/promo', [AppController::class, 'promo']);
    Route::get('/about', [AppController::class, 'about']);
    Route::get('/article', [AppController::class, 'article']);
});

// Data
Route::get('/district', [DataController::class, 'district']);
Route::get('/ward', [DataController::class, 'ward']);
Route::get('/package', [DataController::class, 'package']);

Route::get('/bulk-invoice', [InvoiceController::class, 'bulkCreateInvoice']);
Route::post('/invoice/callback', [InvoiceController::class, 'handleCallback']);
