<?php

use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\DebtCustController;
use App\Http\Controllers\Customer\OrderLaundryController;
use App\Http\Controllers\Employee\CustomerController;
use App\Http\Controllers\Employee\ExpenditureController;
use App\Http\Controllers\Employee\LaundryPackageController;
use App\Http\Controllers\Employee\LaundryServiceController;
use App\Http\Controllers\Employee\OrderController;
use App\Http\Controllers\Employee\PickUpController;
use App\Http\Controllers\Employee\PriceServiceController;
use App\Http\Controllers\Employee\FinanceController;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardOwnerController;
use App\Http\Controllers\Employee\DebtController;
use App\Http\Controllers\Employee\DiscountController as EmployeeDiscountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Owner\EmployeeController;
use App\Http\Controllers\Owner\ServiceController;
use App\Http\Controllers\Owner\Pick_UpController;
use App\Http\Controllers\Owner\PackageController;
use App\Http\Controllers\Owner\LaundryOrderController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\Owner\EmployesController;
use App\Http\Controllers\Owner\CustomersController;
use App\Http\Controllers\Owner\DebtOwnController;
use App\Http\Controllers\Owner\DiscountController;
use App\Http\Controllers\Owner\FinancesController;

Route::get('/landing', function () {
    return view('landing');
});

Route::get('/tracking', [LandingController::class, 'tracking'])
    ->name('tracking');


Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Route::get('/', function () {
//     return view('landing');
// });

Route::get('/', [LandingController::class, 'index'])
    ->name('landing.index');


Route::get('/employee/dashboard',[DashboardController::class, 'employeeDashboard'] )->name('employee.dashboard');
Route::get('/customer/home', function () {
    return view('customer.home');
})->name('customer.home');
Route::get('/owner/dashboard',[DashboardOwnerController::class, 'ownerDashboard'] )->name('owner.dashboard');


Route::get('/dashboard', [DashboardController::class, 'dashboardRoute'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route::post('/gg', [OrderController::class, 'awiwkok']);

Route::post('/employee/ordering/midtrans/callback', [OrderController::class, 'callback']);
Route::get('/employee/ordering/{order}/midtrans-token', [OrderController::class, 'midtransToken'])->name('order.midtrans.token');


require __DIR__.'/auth.php';

Route::get('/coba', function () {
    return view('auth.template');
});

Route::middleware(['auth', 'role:employee'])->group(function () {
Route::get('/employee/index', function () {
    return view('employee.index');
})->name('customer.home');
Route::get('/employee/customers', [CustomerController::class, 'index'])->name('customers.index');
Route::get('/employee/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
Route::put('/employee/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
Route::post('/employee/customers/{id}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('customers.toggleStatus');

Route::get('/employee/ordering', [OrderController::class, 'index'])->name('order.index');
Route::post('/employee/ordering/{id}/status', [OrderController::class, 'updateStatus'])->name('order.updateStatus');
Route::put('/employee/ordering/{id}/weight', [OrderController::class, 'updateWeight'])->name('order.updateWeight');
Route::get('/employee/ordering/create', [OrderController::class, 'create'])->name('order.create');
Route::get('/employee/ordering/{id}/packages', [OrderController::class, 'ajaxPackages']);
Route::post('/employee/ordering/create', [OrderController::class, 'store'])->name('order.store');
Route::get('/employee/ordering/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
Route::delete('/employee/ordering/{id}/destroy', [OrderController::class, 'destroy'])->name('order.destroy');
Route::get('/employee/ordering/history', [OrderController::class, 'history'])->name('order.history');
Route::get('/employee/ordering/{id}/detail', [OrderController::class, 'detail'])->name('order.detaill');
Route::put('/employee/ordering/{id}/payment', [OrderController::class, 'payment'])->name('order.payment');
Route::get('/employee/ordering/history', [OrderController::class, 'history'])->name('order.history');
Route::get('/employee/ordering/payment-receipt', [OrderController::class, 'receipt'])->name('order.receipt');
Route::get('/employee/payment/{id}/receipt', [OrderController::class, 'receipt'])->name('payment.receipt');

Route::get('/employee/ordering/{id}/qris-payment', [OrderController::class, 'qrisPayment'])->name('order.qrisPayment');
Route::put('/employee/ordering/payment/{id}', [OrderController::class, 'processPayment'])->name('ordering.payment');
Route::post('/midtrans/callback', [OrderController::class, 'callback']);

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


Route::get('/employee/discount', [EmployeeDiscountController::class, 'index'])->name('disc.index');
Route::get('/employee/discount/create', [EmployeeDiscountController::class, 'create'])->name('disc.create');
Route::post('/employee/discount/create', [EmployeeDiscountController::class, 'store'])->name('disc.store');
Route::get('/employee/discount/{id}/edit', [EmployeeDiscountController::class, 'edit'])->name('disc.edit');
Route::post('/employee/discount/{id}/update', [EmployeeDiscountController::class, 'update'])->name('disc.update');
Route::delete('/employee/discount/{id}/destroy', [EmployeeDiscountController::class, 'destroy'])->name('disc.destroy');
Route::post('/employee/discount/update-status',[EmployeeDiscountController::class, 'updateStatusAjax'])->name('disc.updateStatusAjax');
Route::post('/employee/discount/sync-status', [EmployeeDiscountController::class, 'syncStatus']);

Route::get('/employee/price-service', [PriceServiceController::class, 'index'])->name('price_service.index');
Route::get('/employee/price-service/create', [PriceServiceController::class, 'create'])->name('price_service.create');
Route::post('/employee/price-service/create', [PriceServiceController::class, 'store'])->name('price_service.store');
Route::get('/employee/price-service/{id}/edit', [PriceServiceController::class, 'edit'])->name('price_service.edit');
Route::post('/employee/price-service/{id}/edit', [PriceServiceController::class, 'update'])->name('price_service.update');
Route::delete('/employee/price-service/{id}/destroy', [PriceServiceController::class, 'destroy'])->name('price_service.destroy');

Route::get('/employee/debt', [DebtController::class, 'index'])->name('debt.index');
Route::put('/employee/debt/{id}', [DebtController::class, 'update'])->name('debt.update');
Route::get('/employee/debt/{id}/receipt', [DebtController::class, 'receipt'])->name('debt.receipt');
Route::get('/employee/debt/history', [DebtController::class, 'history'])->name('debt.history');
Route::get('/employee/debt/order/{order}', [DebtController::class, 'byOrder'])->name('debt.byOrder');

Route::get('/employee/wagw', [MessageController::class, 'wagw'])->name('wagw');
Route::post('/employee/wagw/send', [MessageController::class, 'send'])->name('wagw.send');

Route::get('/employee/finance', [FinanceController::class, 'index'])->name('employee.finance');

Route::get('/employee/pick-up/{id}/detail', [PickUpController::class, 'detail'])->name('pickup.detail');
Route::delete('/employee/pick-up/{id}/destroy', [PickUpController::class, 'destroy'])->name('pickup.destroy');

Route::get('/employee/profile', [ProfileController::class, 'edit_photo'])->name('employee.profile.edit');
Route::patch('/employee/profile', [ProfileController::class, 'update_photo'])->name('employee.profile.update');
});

Route::middleware(['auth', 'role:owner'])->group(function () {
Route::get('/owner/customers', [CustomersController::class, 'index'])->name('customers.index');
Route::post('/owner/customers/{id}/toggle-status', [CustomerController::class, 'toggleStatus'])->name('owner.customers.toggleStatus');

Route::get('/owner/employee', [EmployeeController::class, 'index'])->name('owner.employee.index');
Route::get('/owner/employee/create', [EmployeeController::class, 'create'])->name('owner.employee.create');
Route::post('/owner/employee/create', [EmployeeController::class, 'store'])->name('owner.employee.store');
Route::get('/owner/employee/{id}/edit', [EmployeeController::class, 'edit'])->name('owner.employee.edit');
Route::put('/owner/employee/{id}/edit', [EmployeeController::class, 'update'])->name('owner.employee.update');
Route::get('/owner/employee/{id}/detail', [EmployeeController::class, 'detail'])->name('owner.employee.detail');
Route::put('/owner/employee/{id}/change-password', [EmployeeController::class, 'changePassword'])->name('owner.employee.detail');
Route::delete('/owner/employee/{id}/destroy', [EmployeeController::class, 'destroy'])->name('owner.employee.destroy');

Route::get('/owner/customer', [CustomersController::class, 'index'])->name('owner.employee.index');
Route::get('/owner/order-laundry', [LaundryOrderController::class, 'index'])->name('owner.order.index');
Route::post('/owner/order-laundry/{id}/status', [LaundryOrderController::class, 'updateStatus'])->name('order.updateStatus');
Route::put('/owner/order-laundry/{id}/weight', [LaundryOrderController::class, 'updateWeight'])->name('orderown.updateWeight');
Route::get('/owner/order-laundry/create', [LaundryOrderController::class, 'create'])->name('order.create');
Route::get('/owner/order-laundry/{id}/packages', [LaundryOrderController::class, 'ajaxPackages']);
// Route::post('/owner/order-laundry/create', [LaundryOrderController::class, 'store'])->name('order.store');
Route::post('/owner/order-laundry', [LaundryOrderController::class, 'store'])->name('owner.order.store');
Route::get('/owner/order-laundry/{id}/edit', [LaundryOrderController::class, 'edit'])->name('order.edit');
Route::get('/owner/order-laundry/{id}/detail', [LaundryOrderController::class, 'detail'])->name('order.detail');
Route::put('/owner/order-laundry/{id}/payment', [LaundryOrderController::class, 'payment'])->name('orderown.payment');
Route::get('/owner/order-laundry/history', [LaundryOrderController::class, 'history'])->name('order-own.history');
Route::delete('/owner/order-laundry/{id}/destroy', [LaundryOrderController::class, 'destroy'])->name('owner.order.destroy');
Route::get('/owner/order-laundry/{id}/action', [LaundryOrderController::class, 'actionButtons']);
Route::get('/owner/order-laundry/{id}/receipt', [LaundryOrderController::class, 'receipt'])->name('owner.receipt');


Route::get('/owner/pick-up', [Pick_UpController::class, 'index'])->name('pickup.index');
Route::post('/owner/pick-up/{id}/status', [Pick_UpController::class, 'updateStatus'])->name('pickup.updateStatus');
Route::get('/owner/pick-up/create', [Pick_UpController::class, 'create'])->name('pickup.create');

Route::get('/owner/finance', [FinancesController::class, 'index'])->name('owner.finance');

Route::get('/owner/debt', [DebtOwnController::class, 'index'])->name('debt-own.index');
Route::put('/owner/debt/{id}', [DebtOwnController::class, 'update'])->name('debt-own.update');
Route::get('/owner/debt/{id}/receipt', [DebtOwnController::class, 'receipt'])->name('owner.debt.receipt');
Route::get('/owner/debt/history', [DebtOwnController::class, 'history'])->name('debt.history');
Route::get('/owner/debt/order/{order}', [DebtOwnController::class, 'byOrder'])->name('debt-own.byOrder');

Route::get('/owner/service', [ServiceController::class, 'index'])->name('owner.service.index');
Route::get('/owner/service/create', [ServiceController::class, 'create'])->name('service.create');
Route::post('/owner/service/create', [ServiceController::class, 'store'])->name('service.store');
Route::get('/owner/service/{id}/edit', [ServiceController::class, 'edit'])->name('service.edit');
Route::post('/owner/service/{id}/update', [ServiceController::class, 'update'])->name('service.update');
Route::delete('/owner/service/{id}/destroy', [ServiceController::class, 'destroy'])->name('service.destroy');

Route::get('/owner/discount', [DiscountController::class, 'index'])->name('owner.disc.index');
Route::get('/owner/discount/create', [DiscountController::class, 'create'])->name('owner.disc.create');
Route::post('/owner/discount/create', [DiscountController::class, 'store'])->name('owner.disc.store');
Route::get('/owner/discount/{id}/edit', [DiscountController::class, 'edit'])->name('owner.disc.edit');
Route::post('/owner/discount/{id}/update', [DiscountController::class, 'update'])->name('owner.disc.update');
Route::delete('/owner/discount/{id}/destroy', [DiscountController::class, 'destroy'])->name('owner.disc.destroy');
Route::post('/owner/discount/update-status',[DiscountController::class, 'updateStatusAjax'])->name('owner.disc.updateStatusAjax');
Route::post('/owner/discount/sync-status', [DiscountController::class, 'syncStatus']);



Route::get('/owner/service/{id}/packages', [PackageController::class, 'index'])->name('packages.index');
Route::get('/owner/service/{id}/packages/create', [PackageController::class, 'create'])->name('packages.create');
Route::post('/owner/service/{id}/packages/store', [PackageController::class, 'store'])->name('packages.store');
Route::get('/owner/service/{id}/packages/{packageId}/edit', [PackageController::class, 'edit'])->name('packages.edit');
Route::post('/owner/service/{id}/packages/{packageId}/update', [PackageController::class, 'update'])->name('packages.update');
Route::delete('/owner/service/{id}/packages/{packageId}/destroy', [PackageController::class, 'destroy'])->name('packages.destroy');

Route::get('/owner/profile', [ProfileController::class, 'edit_photo'])->name('owner.profile.edit');
Route::patch('/owner/profile', [ProfileController::class, 'update_photo'])->name('owner.profile.update');
});

Route::middleware(['auth', 'role:customer'])->group(function () {
// Route::get('/customer/dashboard', function () {
//         return view('customer.dashboard');
//     })->name('customer.dashboard');
Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])->name('customer.dashboard');
Route::post('/weather-location', [CustomerDashboardController::class, 'byLocation'])->name('weather.byLocation');

Route::get('/customer/laundry-order', [OrderLaundryController::class, 'index'])->name('laundry-order.index');
Route::get('/customer/laundry-order/create', [OrderLaundryController::class, 'create'])->name('laundry-order.create');
// Route::get('/employee/laundry-service/{id}/packages', [LaundryPackageController::class, 'ajaxPackages']);
Route::get('/customer/laundry-order/{id}/packages', [OrderLaundryController::class, 'ajaxPackages']);
Route::post('/customer/laundry-order/create', [OrderLaundryController::class, 'store'])->name('laundry-order.store');
Route::get('/customer/laundry-order/{id}/edit', [OrderLaundryController::class, 'edit'])->name('laundry-order.edit');
Route::post('/customer/laundry-order/{id}/update', [OrderLaundryController::class, 'update'])->name('laundry-order.update');
Route::delete('/customer/laundry-order/{id}/destroy', [OrderLaundryController::class, 'destroy'])->name('laundry-order.destroy');
Route::get('/customer/laundry-order/history', [OrderLaundryController::class, 'history'])->name('laundry-order.history');

Route::get('/customer/debt', [DebtCustController::class, 'index'])->name('debt.index');

Route::get('/customer/laundry-order/{id}/detail', [OrderLaundryController::class, 'detailorder'])->name('laundry-order.detaill');
Route::get('/customer/laundry-order/history/{id}/detail', [OrderLaundryController::class, 'detail'])->name('laundry-order.detail');

Route::get('/customer/profile', [ProfileController::class, 'edit_photo'])->name('customer.profile.edit');
Route::patch('/customer/profile', [ProfileController::class, 'update_photo'])->name('customer.profile.update');
Route::get('/customer/debt/history', [DebtCustController::class, 'history'])->name('customer.history');
});





