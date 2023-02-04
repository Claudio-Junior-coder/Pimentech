<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\sbrController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\usersController;
use App\Http\Controllers\budgetsController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\settingsController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\providerInfoController;

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

Auth::routes();


//index

Route::get('/home', [HomeController::class, 'index'])->name('index')->middleware('auth');
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');

//settings
Route::get('/settings', [settingsController::class, 'index'])->name('settings')->middleware('auth');


//products

Route::get('/products', [productsController::class, 'index'])->name('products.index')->middleware('auth');

Route::get('/products/create', [productsController::class, 'create'])->name('products.create')->middleware('auth');

Route::get('/products/update/{id}', [productsController::class, 'update'])->name('products.update')->middleware('auth');

Route::post('/products/edit', [productsController::class, 'edit'])->name('products.edit')->middleware('auth');

Route::post('/products/delete', [productsController::class, 'delete'])->name('products.delete')->middleware('auth');


Route::get('/products/check/min-stock', [productsController::class, 'checkMinStock'])->name('products.check.min.stock')->middleware('auth');

//sbr
Route::post('/sbr/create', [sbrController::class, 'create'])->name('sbr.create')->middleware('auth');

Route::post('/sbr/delete', [sbrController::class, 'delete'])->name('sbr.delete')->middleware('auth');

Route::post('/sbr/edit', [sbrController::class, 'edit'])->name('sbr.edit')->middleware('auth');

Route::get('/sbr/get/by/product/{id}', [sbrController::class, 'getByProduct'])->name('sbr.get.by.product')->middleware('auth');

//fornecedores
Route::get('/providers-info', [providerInfoController::class, 'index'])->name('provider.info.index')->middleware('auth');

Route::get('/providers-info/listing', [providerInfoController::class, 'listing'])->name('provider.info.listing')->middleware('auth');

Route::get('/providers-info/create', [providerInfoController::class, 'create'])->name('provider.info.create')->middleware('auth');

Route::get('/providers-info/update/{id}', [providerInfoController::class, 'update'])->name('provider.info.update')->middleware('auth');

Route::post('/providers-info/edit', [providerInfoController::class, 'edit'])->name('provider.info.edit')->middleware('auth');

Route::post('/providers-info/delete', [providerInfoController::class, 'delete'])->name('provider.info.delete')->middleware('auth');



//users
Route::get('/users', [usersController::class, 'index'])->name('user.index')->middleware('auth');

Route::get('/users/listing', [usersController::class, 'listing'])->name('user.listing')->middleware('auth');

Route::get('/users/create', [usersController::class, 'create'])->name('user.create')->middleware('auth');

Route::get('/users/update/{id}', [usersController::class, 'update'])->name('user.update')->middleware('auth');

Route::post('/users/edit', [usersController::class, 'edit'])->name('user.edit')->middleware('auth');

Route::post('/users/delete', [usersController::class, 'delete'])->name('user.delete')->middleware('auth');

Route::get('/users/change/password', function() {
    return view('users.password');
})->name('user.change.password')->middleware('auth');

Route::post('/users/edit/password', [usersController::class, 'editPassword'])->name('user.edit.password')->middleware('auth');

//budgets

Route::get('/budgets', [budgetsController::class, 'index'])->name('budgets.index')->middleware('auth');

Route::get('/budgets/view/{id}', [budgetsController::class, 'view'])->name('budgets.view')->middleware('auth');

Route::post('/budgets/edit', [budgetsController::class, 'edit'])->name('budgets.edit')->middleware('auth');

Route::get('/budgets/pdf/{id}', [budgetsController::class, 'pdf'])->name('budgets.pdf')->middleware('auth');

Route::post('/budgets/create', [budgetsController::class, 'create'])->name('budgets.create')->middleware('auth');

Route::post('/budgets/item/delete', [budgetsController::class, 'deleteBudgetItem'])->name('budgets.item.delete')->middleware('auth');

Route::post('/budgets/items/add', [budgetsController::class, 'addBudgetItem'])->name('budgets.item.add')->middleware('auth');

Route::post('/budgets/create/pdf', [budgetsController::class, 'createPdf'])->name('budgets.create.pdf')->middleware('auth');

Route::post('/budgets/low/stock', [budgetsController::class, 'lowStock'])->name('budgets.low.stock')->middleware('auth');

Route::get('/budgets/search', [budgetsController::class, 'search'])->name('budgets.search')->middleware('auth');

Route::get('/budgets/historic/{id}', [budgetsController::class, 'historic'])->name('budgets.historic')->middleware('auth');

//clientes
Route::get('/customers', [CustomersController::class, 'index'])->name('customers.index')->middleware('auth');

Route::get('/customers/listing', [CustomersController::class, 'listing'])->name('customers.listing')->middleware('auth');

Route::get('/customers/search', [CustomersController::class, 'search'])->name('customers.search')->middleware('auth');

Route::get('/customers/create', [CustomersController::class, 'create'])->name('customers.create')->middleware('auth');

Route::get('/customers/update/{id}', [CustomersController::class, 'update'])->name('customers.update')->middleware('auth');

Route::post('/customers/edit', [CustomersController::class, 'edit'])->name('customers.edit')->middleware('auth');

Route::post('/customers/delete', [CustomersController::class, 'delete'])->name('customers.delete')->middleware('auth');

