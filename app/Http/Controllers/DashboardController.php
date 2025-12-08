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
    $monthlySales = Payment::where('pym_payment_status', 1)
    ->whereMonth('pym_created_at', now()->month)
    ->whereYear('pym_created_at', now()->year)
    ->sum('pym_amount');
    $creditCount = Payment::where('pym_payment_status', 0)->count();
    $credit = Payment::where('pym_payment_status', 0)->sum('pym_debt_amount');
    $income = [1200000, 1500000, 180000 ]; 
     $months = collect();
    $totals = collect();

    // loop 6 bulan terakhir (dari paling lama → terbaru)
    for ($i = 5; $i >= 0; $i--) {
        $date = now()->subMonths($i);

        // nama bulan (Jan, Feb, dst)
        $months->push($date->format('M'));

        // total pemasukan bulan itu
        $totals->push(
            Payment::whereYear('pym_created_at', $date->format('Y'))
                ->whereMonth('pym_created_at', $date->format('m'))
                ->sum('pym_amount')
        );
    }

        // dd($service);
        $member = User::role('customer')->count();
        return view('employee.dashboard',compact(['service','order','orderDone','member','todaySales','credit','monthlySales','creditCount','income','months','totals']));
    }
}
