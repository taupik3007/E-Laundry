<?php

namespace App\Http\Controllers;
use App\Models\LaundryPackage;
use App\Models\LaundryService;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
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
    $now = Carbon::now();
    $lastMonth = Carbon::now()->subMonth();

    // total bulan ini
    $currentIncome = Payment::whereYear('pym_created_at', $now->year)
        ->whereMonth('pym_created_at', $now->month)
        ->sum('pym_amount');

    // total bulan kemarin
    $previousIncome = Payment::whereYear('pym_created_at', $lastMonth->year)
        ->whereMonth('pym_created_at', $lastMonth->month)
        ->sum('pym_amount');

    // hitung persentase
    if ($previousIncome == 0) {
        $percentage = $currentIncome > 0 ? 100 : 0; 
    } else {
        $percentage = (($currentIncome - $previousIncome) / $previousIncome) * 100;
    }
    $percentage =round($percentage, 2);


    // mingguan
    $startOfMonth = Carbon::now()->startOfMonth();
$endOfMonth   = Carbon::now()->endOfMonth();

$weeks  = [];
$totals = [];

$currentStart = $startOfMonth;

while ($currentStart <= $endOfMonth) {

    $currentEnd = $currentStart->copy()->addDays(6);

    if ($currentEnd > $endOfMonth) {
        $currentEnd = $endOfMonth;
    }

    // Label contoh: "01 - 07"
    $weeks[] = $currentStart->format('d') . ' - ' . $currentEnd->format('d');

    $total = Payment::where('pym_payment_status', 1)
        ->whereBetween('pym_created_at', [
            $currentStart->format('Y-m-d') . ' 00:00:00',
            $currentEnd->format('Y-m-d')   . ' 23:59:59'
        ])
        ->sum('pym_amount');

    $totals[] = (int)$total;

    $currentStart = $currentStart->copy()->addDays(7);
}

// Hitung Growth
$growth = 0;

if (count($totals) >= 2) {
    $prev = $totals[count($totals)-2];
    $now  = $totals[count($totals)-1];

    if ($prev > 0) {
        $growth = (($now - $prev) / $prev) * 100;
    }
}

$growth = round($growth, 2);

        // dd($service);
        $member = User::role('customer')->count();
        return view('employee.dashboard',compact(['service','order','orderDone','member','todaySales','credit','monthlySales','creditCount','income','months','totals' ,'currentIncome' ,
        'previousIncome',
        'percentage','weeks' ,
        'totals' ,
        'growth' ]));
    }
}
