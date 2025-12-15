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
    $orderList = Order::with(['service', 'package'])
    ->whereNotIn('ord_status', ['selesai', 'dibatalkan', 'belum lunas'])
    ->orderBy('ord_created_at', 'DESC')
    ->get();

    $service = LaundryService::count();
    $order = Order::whereNotIn('ord_status', ['selesai', 'dibatalkan'])->count();
    $orderDone = Order::whereNotIn('ord_status', ['dibatalkan'])->count();

    $todaySales =  Payment::whereDate('pym_paid_at', Carbon::today())
      ->where('pym_amount', '>', 0)      // sudah ada pembayaran
      ->sum('pym_amount');

    $monthlySales = Payment::where('pym_amount', '>', 0)
      ->whereMonth('pym_paid_at', now()->month)
      ->whereYear('pym_paid_at', now()->year)
      ->sum('pym_amount');

    $creditCount = Payment::where('pym_payment_status', 0)->count();
    $credit      = Payment::where('pym_payment_status', 0)->sum('pym_debt_amount');

    $income = [1200000, 1500000, 180000]; 


    // =========================================================
    //  6 BULAN TERAKHIR (dipakai oleh compact -> months & totals)
    // =========================================================

    $months = collect();
    $totals = collect();

    for ($i = 5; $i >= 0; $i--) {
        $date = now()->subMonths($i);

        $months->push($date->format('M'));

        $totals->push(
            Payment::whereYear('pym_created_at', $date->year)
                ->whereMonth('pym_created_at', $date->month)
                ->sum('pym_amount')
        );
    }


    // =========================================================
    //  GROWTH BULANAN
    // =========================================================
    $now = now();
    $lastMonth = now()->subMonth();

    $currentIncome = Payment::whereYear('pym_created_at', $now->year)
        ->whereMonth('pym_created_at', $now->month)
        ->sum('pym_amount');

    $previousIncome = Payment::whereYear('pym_created_at', $lastMonth->year)
        ->whereMonth('pym_created_at', $lastMonth->month)
        ->sum('pym_amount');

    if ($previousIncome == 0) {
        $percentage = $currentIncome > 0 ? 100 : 0;
    } else {
        $percentage = (($currentIncome - $previousIncome) / $previousIncome) * 100;
    }

    $percentage = round($percentage, 2);


    // =========================================================
    //  PEMASUKAN MINGGUAN (dipisah, tidak bentrok)
    // =========================================================

    $startOfMonth = now()->startOfMonth();
    $endOfMonth   = now()->endOfMonth();

    $weeks = [];       // ini masih ikut compact
    $weekTotals = [];  // INI tidak ikut compact -> aman

    $currentStart = $startOfMonth;

    while ($currentStart <= $endOfMonth) {

        $currentEnd = $currentStart->copy()->addDays(6);
        if ($currentEnd > $endOfMonth) {
            $currentEnd = $endOfMonth;
        }

        // label minggu untuk compact
        $weeks[] = $currentStart->format('d') . ' - ' . $currentEnd->format('d');

        // total mingguan disimpan di variabel terpisah
        $weekTotals[] = Payment::where('pym_payment_status', 1)
            ->whereBetween('pym_created_at', [
                $currentStart->startOfDay(),
                $currentEnd->endOfDay()
            ])
            ->sum('pym_amount');

        $currentStart = $currentStart->copy()->addDays(7);
    }
    
    // GROWTH MINGGUAN
    $growth = 0;

    if (count($weekTotals) >= 2) {
        $prev = $weekTotals[count($weekTotals)-2];
        $nowW = $weekTotals[count($weekTotals)-1];

        if ($prev > 0) {
            $growth = (($nowW - $prev) / $prev) * 100;
        }
    }

    $growth = round($growth, 2);


    // =========================================================
    // MEMBER
    // =========================================================
    $member = User::role('customer')->count();


    // =========================================================
    // COMPACT — TIDAK DIUBAH SAMA SEKALI SESUAI PERMINTAAN AYANG
    // =========================================================
    return view('employee.dashboard',compact([
        'service',
        'order',
        'orderDone',
        'member',
        'todaySales',
        'credit',
        'monthlySales',
        'creditCount',
        'income',
        'months',          // → BULANAN
        'totals',          // → BULANAN (tidak tabrakan)
        'currentIncome',
        'previousIncome',
        'percentage',
        'weeks',           // → label minggu
        'totals',          // tetap tidak diubah (boleh walaupun redundant)
        'growth',
        'orderList'
    ]));
}

}
