<?php

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

use App\Http\Controllers\ReportsController;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    } else {
        return view('auth.login');
    }
});

Route::get('/dashboard', 'HomeController@index')->name('home');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    return 'Cache cleared';
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Customers
Route::group(['prefix'=>'customer', 'middleware' => 'auth'], function () {
    Route::get('/customers-list', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.customers');
    Route::get('/create', [App\Http\Controllers\CustomerController::class, 'create'])->name('customer.create');
    Route::get('/edit/{id}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('customer.edit');
    Route::get('/view/{id}', [App\Http\Controllers\CustomerController::class, 'view'])->name('customer.view');
    Route::post('/store', [App\Http\Controllers\CustomerController::class, 'store'])->name('customer.store');
    Route::post('/update', [App\Http\Controllers\CustomerController::class, 'update'])->name('customer.update');
    Route::post('/delete', [App\Http\Controllers\CustomerController::class, 'delete'])->name('customer.delete');
});

//Parties
Route::group(['prefix'=>'party', 'middleware' => 'auth'], function () {
    Route::get('/parties-list', [App\Http\Controllers\PartyController::class, 'index'])->name('party.parties');
    Route::get('/create', [App\Http\Controllers\PartyController::class, 'create'])->name('party.create');
    Route::get('/edit/{id}', [App\Http\Controllers\PartyController::class, 'edit'])->name('party.edit');
    Route::get('/view/{id}', [App\Http\Controllers\PartyController::class, 'view'])->name('party.view');
    Route::post('/store', [App\Http\Controllers\PartyController::class, 'store'])->name('party.store');
    Route::post('/update', [App\Http\Controllers\PartyController::class, 'update'])->name('party.update');
    Route::post('/delete', [App\Http\Controllers\PartyController::class, 'delete'])->name('party.delete');
});

//Brands
Route::group(['prefix'=>'brand', 'middleware' => 'auth'], function () {
    Route::get('/brands-list', [App\Http\Controllers\BrandsController::class, 'index'])->name('brand.brands');
    Route::get('/create', [App\Http\Controllers\BrandsController::class, 'create'])->name('brand.create');
    Route::get('/edit/{id}', [App\Http\Controllers\BrandsController::class, 'edit'])->name('brand.edit');
    Route::get('/view/{id}', [App\Http\Controllers\BrandsController::class, 'view'])->name('brand.view');
    Route::post('/store', [App\Http\Controllers\BrandsController::class, 'store'])->name('brand.store');
    Route::post('/update', [App\Http\Controllers\BrandsController::class, 'update'])->name('brand.update');
    Route::post('/delete', [App\Http\Controllers\BrandsController::class, 'delete'])->name('brand.delete');

});

//Category
Route::group(['prefix'=>'category', 'middleware' => 'auth'], function () {
    Route::get('/categories-list', [App\Http\Controllers\CategoriesController::class, 'index'])->name('category.categories');
    Route::get('/create', [App\Http\Controllers\CategoriesController::class, 'create'])->name('category.create');
    Route::get('/edit/{id}', [App\Http\Controllers\CategoriesController::class, 'edit'])->name('category.edit');
    Route::get('/view/{id}', [App\Http\Controllers\CategoriesController::class, 'view'])->name('category.view');
    Route::post('/store', [App\Http\Controllers\CategoriesController::class, 'store'])->name('category.store');
    Route::post('/update', [App\Http\Controllers\CategoriesController::class, 'update'])->name('category.update');
    Route::post('/delete', [App\Http\Controllers\CategoriesController::class, 'delete'])->name('category.delete');
});


//Product
Route::group(['prefix'=>'product', 'middleware' => 'auth'], function () {
    Route::get('/products-list', [App\Http\Controllers\ProductsController::class, 'index'])->name('product.products');
    Route::get('/create', [App\Http\Controllers\ProductsController::class, 'create'])->name('product.create');
    Route::get('/edit/{id}', [App\Http\Controllers\ProductsController::class, 'edit'])->name('product.edit');
    Route::get('/view/{id}', [App\Http\Controllers\ProductsController::class, 'view'])->name('product.view');
    Route::post('/store', [App\Http\Controllers\ProductsController::class, 'store'])->name('product.store');
    Route::post('/update', [App\Http\Controllers\ProductsController::class, 'update'])->name('product.update');
    Route::post('/delete', [App\Http\Controllers\ProductsController::class, 'delete'])->name('product.delete');
});

//Purchase
Route::group(['prefix'=>'purchase', 'middleware' => 'auth'], function () {
    Route::get('/purchase-list', [App\Http\Controllers\PurchaseController::class, 'index'])->name('purchase.purchases');
    Route::get('/create', [App\Http\Controllers\PurchaseController::class, 'create'])->name('purchase.create');
    Route::get('/edit/{id}', [App\Http\Controllers\PurchaseController::class, 'edit'])->name('purchase.edit');
    Route::get('/view/{id}', [App\Http\Controllers\PurchaseController::class, 'view'])->name('purchase.view');
    Route::post('/store', [App\Http\Controllers\PurchaseController::class, 'store'])->name('purchase.store');
    Route::post('/update', [App\Http\Controllers\PurchaseController::class, 'update'])->name('purchase.update');
    Route::post('/delete', [App\Http\Controllers\PurchaseController::class, 'delete'])->name('purchase.delete');
    Route::get('/get/brand-products', [App\Http\Controllers\PurchaseController::class, 'getProductsByBrand'])->name('brand.products');
    Route::get('/get/product-detail', [App\Http\Controllers\PurchaseController::class, 'getProductDetail'])->name('product.detail');
});

//Purchase Return
Route::group(['prefix'=>'purchase-return', 'middleware' => 'auth'], function () {
    Route::get('/purchase-return-list', [App\Http\Controllers\PurchaseReturnController::class, 'index'])->name('purchase-return.purchases');
    Route::get('/create', [App\Http\Controllers\PurchaseReturnController::class, 'create'])->name('purchase-return.create');
    Route::get('/edit/{id}', [App\Http\Controllers\PurchaseReturnController::class, 'edit'])->name('purchase-return.edit');
    Route::get('/view/{id}', [App\Http\Controllers\PurchaseReturnController::class, 'view'])->name('purchase-return.view');
    Route::post('/store', [App\Http\Controllers\PurchaseReturnController::class, 'store'])->name('purchase-return.store');
    Route::post('/update', [App\Http\Controllers\PurchaseReturnController::class, 'update'])->name('purchase-return.update');
    Route::post('/delete', [App\Http\Controllers\PurchaseReturnController::class, 'delete'])->name('purchase-return.delete');
    Route::get('/get/brand-products', [App\Http\Controllers\PurchaseReturnController::class, 'getProductsByBrand'])->name('brand.products');
    Route::get('/get/product-detail', [App\Http\Controllers\PurchaseReturnController::class, 'getProductDetail'])->name('product.detail');
});

//Sales
Route::group(['prefix'=>'sale', 'middleware' => 'auth'], function () {
    Route::get('/sales-list', [App\Http\Controllers\SalesController::class, 'index'])->name('sale.sales');
    Route::get('/create', [App\Http\Controllers\SalesController::class, 'create'])->name('sale.create');
    Route::get('/edit/{id}', [App\Http\Controllers\SalesController::class, 'edit'])->name('sale.edit');
    Route::get('/view/{id}', [App\Http\Controllers\SalesController::class, 'view'])->name('sale.view');
    Route::post('/store', [App\Http\Controllers\SalesController::class, 'store'])->name('sale.store');
    Route::post('/update', [App\Http\Controllers\SalesController::class, 'update'])->name('sale.update');
    Route::post('/delete', [App\Http\Controllers\SalesController::class, 'delete'])->name('sale.delete');
    Route::get('/get/brand-products', [App\Http\Controllers\SalesController::class, 'getProductsByBrand'])->name('brand.products');
    Route::get('/get/product-detail', [App\Http\Controllers\SalesController::class, 'getProductDetail'])->name('product.detail');
});

//Sales return
Route::group(['prefix'=>'sale-return', 'middleware' => 'auth'], function () {
    Route::get('/sales-return-list', [App\Http\Controllers\SalesReturnController::class, 'index'])->name('sale-return.sales-return');
    Route::get('/create', [App\Http\Controllers\SalesReturnController::class, 'create'])->name('sale-return.create');
    Route::get('/edit/{id}', [App\Http\Controllers\SalesReturnController::class, 'edit'])->name('sale-return.edit');
    Route::get('/view/{id}', [App\Http\Controllers\SalesReturnController::class, 'view'])->name('sale-return.view');
    Route::post('/store', [App\Http\Controllers\SalesReturnController::class, 'store'])->name('sale-return.store');
    Route::post('/update', [App\Http\Controllers\SalesReturnController::class, 'update'])->name('sale-return.update');
    Route::post('/delete', [App\Http\Controllers\SalesReturnController::class, 'delete'])->name('sale-return.delete');
    Route::get('/get/brand-products', [App\Http\Controllers\SalesReturnController::class, 'getProductsByBrand'])->name('brand.products');
    Route::get('/get/product-detail', [App\Http\Controllers\SalesReturnController::class, 'getProductDetail'])->name('product.detail');
});

//Delivery Charges
Route::group(['prefix'=>'delivery-charges', 'middleware' => 'auth'], function () {
    Route::get('/dc-list', [App\Http\Controllers\DeliveryChargesController::class, 'index'])->name('delivery-charges.dc-list');
    Route::get('/create', [App\Http\Controllers\DeliveryChargesController::class, 'create'])->name('delivery-charges.create');
    Route::get('/edit/{id}', [App\Http\Controllers\DeliveryChargesController::class, 'edit'])->name('delivery-charges.edit');
    Route::get('/view/{id}', [App\Http\Controllers\DeliveryChargesController::class, 'view'])->name('delivery-charges.view');
    Route::post('/store', [App\Http\Controllers\DeliveryChargesController::class, 'store'])->name('delivery-charges.store');
    Route::post('/update', [App\Http\Controllers\DeliveryChargesController::class, 'update'])->name('delivery-charges.update');
    Route::post('/delete', [App\Http\Controllers\DeliveryChargesController::class, 'delete'])->name('delivery-charges.delete');
});

//Bank Payment Voucher
Route::group(['prefix' => 'bpv', 'middleware' => 'auth'], function () {
    Route::get('list', ['as' => 'bpv.list', 'uses' => 'BankPaymentVouchersController@index']);
    Route::get('create', ['as' => 'bpv.create', 'uses' => 'BankPaymentVouchersController@create']);
    Route::post('save', ['as' => 'bpv.save', 'uses' => 'BankPaymentVouchersController@store']);
    Route::get('edit/{id}', ['as' => 'bpv.edit', 'uses' => 'BankPaymentVouchersController@edit']);
    Route::post('update', ['as' => 'bpv.update', 'uses' => 'BankPaymentVouchersController@store']);
    Route::post('delete', ['as' => 'bpv.delete', 'uses' => 'BankPaymentVouchersController@destroy']);
    Route::post('show/{id}', ['as' => 'bpv.show', 'uses' => 'BankPaymentVouchersController@show']);
    Route::get('search', ['as' => 'bpv.search', 'uses' => 'BankPaymentVouchersController@search']);
});

//Bank Receipt Voucher
Route::group(['prefix' => 'brv', 'middleware' => 'auth'], function () {
    Route::get('list', ['as' => 'brv.list', 'uses' => 'BankReceiptVouchersController@index']);
    Route::get('create', ['as' => 'brv.create', 'uses' => 'BankReceiptVouchersController@create']);
    Route::post('save', ['as' => 'brv.save', 'uses' => 'BankReceiptVouchersController@store']);
    Route::get('edit/{id}', ['as' => 'brv.edit', 'uses' => 'BankReceiptVouchersController@edit']);
    Route::post('update', ['as' => 'brv.update', 'uses' => 'BankReceiptVouchersController@store']);
    Route::post('delete', ['as' => 'brv.delete', 'uses' => 'BankReceiptVouchersController@destroy']);
    Route::post('show/{id}', ['as' => 'brv.show', 'uses' => 'BankReceiptVouchersController@show']);
    Route::get('search', ['as' => 'brv.search', 'uses' => 'BankReceiptVouchersController@search']);
    Route::get('preview-file/{file}', ['as' => 'preview.file', 'uses' => 'BankReceiptVouchersController@previewAttachment']);

});

//Cash Receipt Voucher
Route::group(['prefix' => 'crv', 'middleware' => 'auth'], function () {
    Route::get('list', ['as' => 'crv.list', 'uses' => 'CashReceiptVouchersController@index']);
    Route::get('create', ['as' => 'crv.create', 'uses' => 'CashReceiptVouchersController@create']);
    Route::post('save', ['as' => 'crv.save', 'uses' => 'CashReceiptVouchersController@store']);
    Route::get('edit/{id}', ['as' => 'crv.edit', 'uses' => 'CashReceiptVouchersController@edit']);
    Route::post('update', ['as' => 'crv.update', 'uses' => 'CashReceiptVouchersController@update']);
    Route::post('delete', ['as' => 'crv.delete', 'uses' => 'CashReceiptVouchersController@destroy']);
    Route::post('view/{id}', ['as' => 'crv.view', 'uses' => 'CashReceiptVouchersController@show']);
    Route::get('search', ['as' => 'crv.search', 'uses' => 'CashReceiptVouchersController@search']);
});

//Cash Payment Voucher
Route::group(['prefix' => 'cpv', 'middleware' => 'auth'], function () {
    Route::get('list', ['as' => 'cpv.list', 'uses' => 'CashPaymentVouchersController@index']);
    Route::get('create', ['as' => 'cpv.create', 'uses' => 'CashPaymentVouchersController@create']);
    Route::post('save', ['as' => 'cpv.save', 'uses' => 'CashPaymentVouchersController@store']);
    Route::get('edit/{id}', ['as' => 'cpv.edit', 'uses' => 'CashPaymentVouchersController@edit']);
    Route::post('update', ['as' => 'cpv.update', 'uses' => 'CashPaymentVouchersController@update']);
    Route::post('delete', ['as' => 'cpv.delete', 'uses' => 'CashPaymentVouchersController@destroy']);
    Route::post('show/{id}', ['as' => 'cpv.show', 'uses' => 'CashPaymentVouchersController@show']);
    Route::get('search', ['as' => 'cpv.search', 'uses' => 'CashPaymentVouchersController@search']);
});

//Bank Registration
Route::group(['prefix' => 'bank', 'middleware' => 'auth'], function () {
    Route::get('list', ['as' => 'bank.list', 'uses' => 'BanksController@index']);
    Route::get('create', ['as' => 'bank.create', 'uses' => 'BanksController@create']);
    Route::post('save', ['as' => 'bank.save', 'uses' => 'BanksController@store']);
    Route::get('edit/{id}', ['as' => 'bank.edit', 'uses' => 'BanksController@edit']);
    Route::post('update', ['as' => 'bank.update', 'uses' => 'BanksController@store']);
    Route::post('delete', ['as' => 'bank.delete', 'uses' => 'BanksController@destroy']);
    Route::post('show/{id}', ['as' => 'bank.show', 'uses' => 'BanksController@show']);
    Route::get('search', ['as' => 'bank.search', 'uses' => 'BanksController@search']);
});

//Sales
Route::group(['prefix'=>'account-ledger', 'middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\AccountsLedgerController::class, 'index'])->name('account-ledger.ledger');
    Route::get('/view', [App\Http\Controllers\AccountsLedgerController::class, 'view'])->name('account-ledger.view');
});

//Accounts
Route::group(['prefix'=>'account', 'middleware' => 'auth'], function () {
    Route::get('/accounts-list', [App\Http\Controllers\AccountsController::class, 'index'])->name('account.accounts');
    Route::get('/create', [App\Http\Controllers\AccountsController::class, 'create'])->name('account.create');
    Route::get('/edit/{id}', [App\Http\Controllers\AccountsController::class, 'edit'])->name('account.edit');
    Route::get('/view/{id}', [App\Http\Controllers\AccountsController::class, 'view'])->name('account.view');
    Route::post('/store', [App\Http\Controllers\AccountsController::class, 'store'])->name('account.store');
    Route::post('/update', [App\Http\Controllers\AccountsController::class, 'update'])->name('account.update');
    Route::post('/delete', [App\Http\Controllers\AccountsController::class, 'delete'])->name('account.delete');
});

//Stock
Route::group(['prefix'=>'stock', 'middleware' => 'auth'], function () {
    Route::get('/', [App\Http\Controllers\StockController::class, 'index'])->name('stock.report');
    Route::get('/view', [App\Http\Controllers\StockController::class, 'view'])->name('stock.view');
});

//Users
Route::group(['prefix'=>'user', 'middleware' => 'auth'], function () {
    Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('user.users');
    Route::get('/create', [App\Http\Controllers\UsersController::class, 'create'])->name('user.create');
    Route::get('/edit/{id}', [App\Http\Controllers\UsersController::class, 'edit'])->name('user.edit');
    Route::get('/view/{id}', [App\Http\Controllers\UsersController::class, 'view'])->name('user.view');
    Route::post('/store', [App\Http\Controllers\UsersController::class, 'store'])->name('user.store');
    Route::post('/update', [App\Http\Controllers\UsersController::class, 'update'])->name('user.update');
    Route::post('/delete', [App\Http\Controllers\UsersController::class, 'delete'])->name('user.delete');
});

Route::get('/clear-cache', function() {
//    $output = new \Symfony\Component\Console\Output\BufferedOutput;
    \Artisan::call('cache:clear', []);
    \Artisan::call('config:clear', []);
    \Artisan::call('route:clear', []);
    \Artisan::call('view:clear', []);
    dd('Cache cleared');
});
