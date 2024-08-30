<?php

use App\Http\Controllers\LookUpController;
use App\Http\Controllers\OrderslipController;
use App\Http\Resources\OrderSlip;
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

Route::view('/settings', 'pages.settings')->name('settings');
Route::post('/settings', [App\Http\Controllers\SettingController::class, 'settings']);

Route::view('/login', 'pages.login')->name('login')->middleware('guest');
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login']);

Route::middleware('auth')->group(function () {

    Route::get('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');
    Route::view('/', 'pages.index')->name('home');
    // Route::view('/home', 'pages.index')->name('home');
    Route::view('/user-info', 'pages.user-info')->name('user_info');

    Route::get('/stores', [App\Http\Controllers\StoreController::class, 'index'])->name('stores');
    Route::get('/stores/{store_slug}', [App\Http\Controllers\StoreController::class, 'showStoreProductsPage'])->name('stores.store_products_page');
    Route::get('/stores/{store_slug}/product', [App\Http\Controllers\StoreController::class, 'showStoreProductPage'])->name('stores.store_product_page');
    Route::get('/stores/{store_id}/products', [App\Http\Controllers\StoreController::class, 'showStoreProducts'])->name('stores.store_products');
    Route::get('/orderslips', [App\Http\Controllers\OrderslipController::class, 'index'])->name('orderslips');
    Route::get('/orderslips/{orderslip_code}', [App\Http\Controllers\OrderslipController::class, 'orderslipOverview'])->name('orderslips.overview');
    Route::post('/orderslips', [App\Http\Controllers\OrderslipController::class, 'store']);
    Route::post('/current-transaction', [App\Http\Controllers\CurrentTransactionController::class, 'currentTransaction']);
    Route::post('/detach-current-transaction', [App\Http\Controllers\CurrentTransactionController::class, 'detachCurrentTransaction']);
    Route::post('/attach-current-transaction', [App\Http\Controllers\CurrentTransactionController::class, 'attachCurrentTransaction']);
    Route::post('/add-to-cart', [App\Http\Controllers\AddToCartController::class, 'addToCart'])->name('add_to_cart');
    Route::post('/edit-item-on-cart', [App\Http\Controllers\CartController::class, 'editItemOnCart'])->name('edit_item_on_cart');
    Route::post('/remove-item-on-cart', [App\Http\Controllers\CartController::class, 'removeItemOnCart'])->name('remove_item_on_cart');
    Route::patch('/plate-number', [App\Http\Controllers\PlateNumberController::class, 'update'])->name('update_plate_number');
    Route::patch('/total-head-count', [App\Http\Controllers\TotalHeadCountController::class, 'update'])->name('total_head_count.update');
    Route::post('/open-shift', [App\Http\Controllers\ShiftController::class, 'openShift'])->name('open-shift');
    Route::post('/close-shift', [App\Http\Controllers\CloseShiftController::class, 'closeShift'])->name('close-shift');
    Route::post('/close-day', [App\Http\Controllers\CloseDayController::class, 'closeDay'])->name('close_day');

    Route::post('/mark-as-complete', [App\Http\Controllers\CurrentTransactionController::class, 'markAsComplete']);
    Route::view('/servery', 'pages.servery')->name('servery');
    Route::view('/completed-orders', 'pages.completed-orderslip')->name('completed_orders');

    Route::get('/vendors/{id}', [App\Http\Controllers\VendorController::class, 'show'])->name('vendors.show');
    Route::get('/vendors', [App\Http\Controllers\VendorController::class, 'index'])->name('vendors');
    Route::get('/postmixes', [App\Http\Controllers\PostmixController::class, 'index']);
    Route::get('/outlet-products', [App\Http\Controllers\OutletProductController::class, 'index']);
    Route::get('/outlet-products/{product_id}', [App\Http\Controllers\OutletProductController::class, 'show']);
    Route::patch('/orderslip-senior-status', [App\Http\Controllers\OrderslipSeniorStatusController::class, 'update']);
    Route::post('/orderslip-seniors', [App\Http\Controllers\OrderslipSeniorController::class, 'store']);
    Route::patch('/orderslip-seniors/{id}', [App\Http\Controllers\OrderslipSeniorController::class, 'update']);
    Route::delete('/orderslip-seniors/{id}', [App\Http\Controllers\OrderslipSeniorController::class, 'destroy']);

    Route::delete('/cart-item', [App\Http\Controllers\CartItemController::class, 'destroy']);
    Route::patch('/cart-item', [App\Http\Controllers\CartItemController::class, 'update']);

    Route::patch('/customer-display', [App\Http\Controllers\CartController::class, 'customerDisplay']);

    Route::get('/tables', [App\Http\Controllers\TableFileController::class, 'index']);
    Route::post('/orderslip-tables', [App\Http\Controllers\OrderslipTableController::class, 'store']);
    Route::delete('/orderslip-tables', [App\Http\Controllers\OrderslipTableController::class, 'destroy']);
    Route::patch('/confirm-order', [App\Http\Controllers\OrderSlipConfirmController::class, 'update']);
    Route::post('/reprint-order-in-kitchen', [App\Http\Controllers\ReprintOrderInKitchenController::class, 'store']);
    Route::patch('/table-cleaner', [App\Http\Controllers\TableCleanerController::class, 'update']);
    Route::get('/menu', [App\Http\Controllers\RestaurantMenuController::class, 'index']);
    Route::get('/outlet-groups', [App\Http\Controllers\OutletGroupController::class, 'index']);

    Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'index']);
    Route::patch('/orderslips/{orderslip_code}/customer', [App\Http\Controllers\OrderslipCustomerController::class, 'update']);
    Route::delete('/orderslips/{orderslip_code}/customer', [App\Http\Controllers\OrderslipCustomerController::class, 'destroy']);
    Route::post('/orderslips/{orderslip_code}/send-to-email', [App\Http\Controllers\OrderslipSendToEmailController::class, 'store']);

    Route::get('/official-receipts/{id}', [App\Http\Controllers\OfficialReceiptController::class, 'show']);
    Route::get('/official-receipts', [App\Http\Controllers\OfficialReceiptController::class, 'index']);
    Route::post('/official-receipts', [App\Http\Controllers\OfficialReceiptController::class, 'store']);

    Route::post('/official-receipts/{id}/customer', [App\Http\Controllers\OfficialReceiptCustomerController::class, 'store']);
    Route::delete('/official-receipts/{id}/customer', [App\Http\Controllers\OfficialReceiptCustomerController::class, 'destroy']);

    Route::post('/official-receipts/{id}/email-sender', [App\Http\Controllers\OfficialReceiptEmailSenderController::class, 'store']);

    Route::get('/customer-accounts', [App\Http\Controllers\CustomerAccountController::class, 'index']);
    Route::get('/customer-accounts/{id}/unpaid-invoices', [App\Http\Controllers\UnpaidInvoiceController::class, 'index']);
    Route::get('/mode-of-payments', [App\Http\Controllers\ModeOfPaymentController::class, 'index']);
    Route::post('/official-receipts/{id}/invoice', [App\Http\Controllers\OfficialReceiptInvoiceController::class, 'store']);


    Route::post('/change-order-type', [App\Http\Controllers\ChangeOrderTypeController::class, 'store']);
    Route::patch('/shell-confirm-order/{os_number}', [App\Http\Controllers\ShellConfirmOrderController::class, 'update']);

    Route::get('/pos-print', [App\Http\Controllers\PosPrintController::class, 'index']);

    Route::get('/AddNewJO',[OrderslipController::class,'AddNewJO']);
    Route::get('/getDiscounts', [LookUpController::class, 'getDiscount']);

});

Route::get('/app-setting', [App\Http\Controllers\AppSettingController::class, 'index']);
