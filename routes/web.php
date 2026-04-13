<?php

use App\Http\Controllers\CompanyRegisterController;
use App\Http\Controllers\ZohoWebhookController;
use App\Http\Controllers\PerfiosWebhookController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

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
    return view('welcome');
});
Route::get('/customer', function (ZohoBookService $zoho) {
    $res = $zoho->getAllCustomer();
    return $res;
});
Route::get('/customer/{id}', function (ZohoBookService $zoho, $id) {
    $res = $zoho->getCustomer($id);
    return $res;
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::prefix('company-register')->group(function () {
    Route::get('/invitation/{token}', [CompanyRegisterController::class, 'index'])->name('company.register');
    Route::post('/submit', [CompanyRegisterController::class, 'store'])->name('company.submit');
    Route::get('client-gstin-check', [CompanyRegisterController::class, 'gstVerification'])->name('company.gst.check');
});

Route::get('invalid-link', [CompanyRegisterController::class, 'InvalidLink'])->name('invalid-link');
Route::get('vivasvanna-export', [CompanyRegisterController::class, 'welcome'])->name('welcome');

///////// || ZohoWebhook Controller || \\\\\\\\\\
Route::post('/webhooks/zoho/{module}', [ZohoWebhookController::class, 'handle']);

Route::post('/webhooks-perfios/gst_trrn', [PerfiosWebhookController::class, 'handleGstCallback'])->name('perfios.webhook.gst');
Route::post('/webhooks-perfios/bsa',     [PerfiosWebhookController::class, 'handleBsaCallback'])->name('perfios.webhook.bsa');
