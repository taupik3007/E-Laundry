<?php

namespace App\Http\Controllers;
use App\Models\LaundryPackage;
use App\Models\LaundryService;
use App\Models\Order;
use App\Models\Payment;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    function employeeDashboard(){
        $service = LaundryService::count();
        $order = Order::with(['service', 'package'])
    ->whereNotIn('ord_status', ['selesai', 'dibatalkan'])
    ->count();
    $orderDone = Order::with(['service', 'package'])
    ->whereNotIn('ord_status', ['dibatalkan'])
    ->count();
    $todaySales = Payment::where('pym_payment_status', 1)
    ->whereDate('pym_created_at', today())
    ->sum('pym_amount');

        // dd($service);
        $member = User::role('customer')->count();
        return view('employee.dashboard',compact(['service','order','orderDone','member','todaySales']));
    }
}
