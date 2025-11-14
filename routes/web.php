<?php

use App\Http\Controllers\Customer\OrderLaundryController;
use App\Http\Controllers\Employee\CustomerController;
use App\Http\Controllers\Employee\ExpenditureController;
use App\Http\Controllers\Employee\LaundryPackageController;
use App\Http\Controllers\Employee\LaundryServiceController;
use App\Http\Controllers\Employee\OrderController;
use App\Http\Controllers\Employee\PickUpController;
use App\Http\Controllers\Employee\PriceServiceController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Owner\EmployeeController;
use App\Http\Controllers\Employee\ServiceController;
use App\Http\Controllers\Owner\EmployesController;
use App\Http\Controllers\Owner\CustomersController;

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employee/dashboard', function () {
    return view('employee.dashboard');
})->name('employee.dashboard');
Route::get('/customer/home', function () {
    return view('customer.home');
})->name('customer.home');
Route::get('/owner/dashboard', function () {
    return view('owner.dashboard');
})->name('owner.dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/coba', function () {
    return view('auth.template');
});
Route::get('/employee/index', function () {
    return view('employee.index');
})->name('customer.home');
Route::get('/employee/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/employee/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/employee/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
Route::post('/employee/customers/{id}/toggle-status', [CustomerController::class, 'toggleStatus'])
    ->name('customers.toggleStatus');

Route::get('/employee/ordering', [OrderController::class, 'index'])->name('order.index');
Route::get('/employee/ordering/create', [OrderController::class, 'create'])->name('order.create');
Route::get('/employee/ordering/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
Route::get('/employee/ordering/history', [OrderController::class, 'history'])->name('order.history');
Route::get('/employee/ordering/{id}/detail', [OrderController::class, 'detail'])->name('order.detaill');

Route::get('/employee/expenditure', [ExpenditureController::class, 'index'])->name('expenditure.index');
Route::get('/employee/expenditure/create', [ExpenditureController::class, 'create'])->name('expenditure.create');

Route::get('/employee/pick-up', [PickUpController::class, 'index'])->name('pickup.index');
Route::post('/employee/pick-up/{id}/status', [PickUpController::class, 'updateStatus'])->name('pickup.updateStatus');
Route::get('/employee/pick-up/create', [PickUpController::class, 'create'])->name('pickup.create');


Route::get('/employee/laundry-service', [LaundryServiceController::class, 'index'])->name('laundry-service.index');
Route::get('/employee/laundry-service/create', [LaundryServiceController::class, 'create'])->name('laundry-service.create');
Route::post('/employee/laundry-service/create', [LaundryServiceController::class, 'store'])->name('laundry-service.store');
Route::get('/employee/laundry-service/{id}/edit', [LaundryServiceController::class, 'edit'])->name('laundry-service.edit');
Route::post('/employee/laundry-service/{id}/update', [LaundryServiceController::class, 'update'])->name('laundry-service.update');
Route::delete('/employee/laundry-service/{id}/destroy', [LaundryServiceController::class, 'destroy'])->name('laundry-service.destroy');

Route::get('/employee/laundry-service/{id}/package', [LaundryPackageController::class, 'index'])->name('package.index');
Route::get('/employee/laundry-service/{id}/package/create', [LaundryPackageController::class, 'create'])->name('package.create');
Route::post('/employee/laundry-service/{id}/package/store', [LaundryPackageController::class, 'store'])->name('package.store');
Route::get('/employee/laundry-service/{id}/package/{packageId}/edit', [LaundryPackageController::class, 'edit'])->name('package.edit');
Route::post('/employee/laundry-service/{id}/package/{packageId}/update', [LaundryPackageController::class, 'update'])->name('package.update');
Route::delete('/employee/laundry-service/{id}/package/{packageId}/destroy', [LaundryPackageController::class, 'destroy'])->name('package.destroy');

Route::get('/employee/price-service', [PriceServiceController::class, 'index'])->name('price_service.index');
Route::get('/employee/price-service/create', [PriceServiceController::class, 'create'])->name('price_service.create');
Route::post('/employee/price-service/create', [PriceServiceController::class, 'store'])->name('price_service.store');
Route::get('/employee/price-service/{id}/edit', [PriceServiceController::class, 'edit'])->name('price_service.edit');
Route::post('/employee/price-service/{id}/edit', [PriceServiceController::class, 'update'])->name('price_service.update');
Route::delete('/employee/price-service/{id}/destroy', [PriceServiceController::class, 'destroy'])->name('price_service.destroy');

Route::get('/employee/pick-up/{id}/detail', [PickUpController::class, 'detail'])->name('pickup.detail');
Route::delete('/employee/pick-up/{id}/destroy', [PickUpController::class, 'destroy'])->name('pickup.destroy');

Route::get('/owner/customers', [CustomersController::class, 'index'])->name('customers.index');

Route::get('/owner/employee', [EmployeeController::class, 'index'])->name('employee.index');
Route::get('/owner/employee/create', [EmployeeController::class, 'create'])->name('employee.create');
Route::post('/owner/employee/create', [EmployeeController::class, 'store'])->name('employee.store');
Route::get('/owner/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
Route::put('/owner/employee/{id}/edit', [EmployeeController::class, 'update'])->name('employee.update');
Route::get('/owner/employee/{id}/detail', [EmployeeController::class, 'detail'])->name('employee.detail');
Route::delete('/owner/employee/{id}/destroy', [EmployeeController::class, 'destroy'])->name('employee.destroy');

Route::get('/customer/laundry-order', [OrderLaundryController::class, 'index'])->name('laundry-order.index');
Route::get('/customer/laundry-order/create', [OrderLaundryController::class, 'create '])->name('laundry-order.create');
Route::get('/customer/laundry-order/{id}/detail', [OrderLaundryController::class, 'detail'])->name('laundry-order.detaill');

