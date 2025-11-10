<?php

use App\Http\Controllers\Customer\OrderLaundryController;
use App\Http\Controllers\Employee\CustomerController;
use App\Http\Controllers\Employee\ExpenditureController;
use App\Http\Controllers\Employee\OrderController;
use App\Http\Controllers\Employee\PickUpController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\Owner\EmployeeController;
use App\Http\Controllers\Employee\ServiceController;
use App\Http\Controllers\Owner\EmployesController;

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/employee/dashboard', function () {
    return view('employee.dashboard');
})->name('employee.dashboard');
Route::get('/customer/home', function () {
    return view('customer.index');
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


Route::get('/employee/service', [ServiceController::class, 'index'])->name('service.index');

Route::get('/employee/pick-up/{id}/detail', [PickUpController::class, 'detail'])->name('pickup.detail');
Route::delete('/employee/pick-up/{id}/destroy', [PickUpController::class, 'destroy'])->name('pickup.destroy');


Route::get('/owner/employee', [EmployeeController::class, 'index'])->name('employee.index');
Route::get('/owner/employee/create', [EmployeeController::class, 'store'])->name('employee.create');
Route::get('/owner/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
Route::put('/owner/employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');
Route::get('/owner/employee/{id}/detail', [EmployeeController::class, 'detail'])->name('employee.detail');

Route::get('/customer/laundry-order', [OrderLaundryController::class, 'index'])->name('laundry-order.index');
Route::get('/customer/laundry-order/create', [OrderLaundryController::class, 'create '])->name('laundry-order.create');
Route::get('/customer/laundry-order/{id}/detail', [OrderLaundryController::class, 'detail'])->name('laundry-order.detaill');

