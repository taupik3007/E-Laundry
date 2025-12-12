<?php

namespace App\Http\Controllers;
namespace App\Http\Controllers;
use App\Models\LaundryPackage;
use App\Models\LaundryService;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function ownerDashboard(){
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

        // dd($service);
        $member = User::role('customer')->count();
        return view('owner.dashboard',compact(['service','order','orderDone','member','todaySales','credit','monthlySales','creditCount','income','months','totals' ,'currentIncome' ,
        'previousIncome',
        'percentage' ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
