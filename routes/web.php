<?php

use App\Http\Controllers\Employee\CustomerController;
use App\Http\Controllers\Owner\EmployeeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;

Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

Route::get('/', function () {
    return view('welcome');
});


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
});
Route::get('/employee/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/employee/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/employee/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');

Route::get('/owner/employee', [EmployeeController::class, 'index'])->name('employee.index');
Route::get('/owner/employee', [EmployeeController::class, 'store'])->name('employee.create');
Route::get('/owner/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('employee.edit');
Route::put('/owner/employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');