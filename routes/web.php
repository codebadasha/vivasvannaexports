<?php

use App\Http\Controllers\CompanyRegisterController;
use App\Http\Controllers\ZohoWebhookController;
use App\Services\ZohoBookService;
use Illuminate\Support\Facades\Log;
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
    return view('welcome');
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



Route::get('/test-invoices', function (ZohoBookService $zohoBook) {
    try {
        $params = request()->all(); // Get query params if any (e.g., ?page=1&per_page=10)
        $invoices = $zohoBook->getAllInvoices($params);
        return response()->json($invoices);
    } catch (\Exception $e) {
        Log::error('Invoice fetch error', ['message' => $e->getMessage(), 'params' => request()->all()]);
        return response()->json(['error' => 'Failed to fetch invoices'], 500);
    }
});


Route::get('/customer', function (ZohoBookService $zohoBook) {
    try {
        $item = $zohoBook->getAllCustomer();
        
        return response()->json($item);
    } catch (\Exception $e) {
        Log::error('Item fetch error', ['item_id' => 1, 'message' => $e->getMessage()]);
        return response()->json(['error' => 'Failed to fetch item'], 500);
    }
});
Route::get('/customer/{customerId}', function (ZohoBookService $zohoBook, string $customerId) {
    try {
        $item = $zohoBook->getCustomer($customerId);
        
        return response()->json($item);
    } catch (\Exception $e) {
        Log::error('Item fetch error', ['item_id' => 1, 'message' => $e->getMessage()]);
        return response()->json(['error' => 'Failed to fetch item'], 500);
    }
});

Route::post('/test-create-item', function (ZohoBookService $zohoBook) {
    try {
        $data = request()->validate([
            'name' => 'required|string',
            'rate' => 'required|numeric',
            'description' => 'string|nullable',
        ]);
        $item = $zohoBook->createItem($data);
        return response()->json($item, 201); // 201 Created
    } catch (\Exception $e) {
        Log::error('Item creation error', ['data' => request()->all(), 'message' => $e->getMessage()]);
        return response()->json(['error' => 'Failed to create item'], 500);
    }
});

Route::put('/test-update-item/{itemId}', function (ZohoBookService $zohoBook, string $itemId) {
    try {
        $data = request()->validate([
            'name' => 'string|nullable',
            'rate' => 'numeric|nullable',
            'description' => 'string|nullable',
        ]);
        $item = $zohoBook->updateItem($itemId, $data);
        return response()->json($item);
    } catch (\Exception $e) {
        Log::error('Item update error', ['item_id' => $itemId, 'data' => request()->all(), 'message' => $e->getMessage()]);
        return response()->json(['error' => 'Failed to update item'], 500);
    }
});

Route::delete('/test-delete-item/{itemId}', function (ZohoBookService $zohoBook, string $itemId) {
    try {
        $result = $zohoBook->deleteItem($itemId);
        return response()->json(['message' => 'Item deleted'], 200);
    } catch (\Exception $e) {
        Log::error('Item delete error', ['item_id' => $itemId, 'message' => $e->getMessage()]);
        return response()->json(['error' => 'Failed to delete item'], 500);
    }
});