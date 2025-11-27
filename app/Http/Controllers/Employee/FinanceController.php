<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;

class FinanceController extends Controller
{
    function index(){
        $todayIncome = Payment::whereDate('pym_paid_at', Carbon::today())->whereHas('order', function ($q) {
            $q->where('ord_status', 'Selesai');
        })
            ->sum('pym_amount_paid');
            $monthIncome = Payment::where('pym_payment_status', 1)
    ->whereMonth('pym_paid_at', now()->month)
    ->whereYear('pym_paid_at', now()->year)->whereHas('order', function ($q) {
        $q->where('ord_status', 'Selesai');
    })
    ->sum('pym_amount_paid');

    $payments = Payment::with(['order'])
    ->where('pym_payment_status', 1)
    ->whereHas('order', function ($q) {
        $q->where('ord_status', 'Selesai');
    })
    ->orderBy('pym_paid_at', 'DESC')
    ->get();


        return view('employee.finance.index',compact(['todayIncome','monthIncome', 'payments']));
    }
}
