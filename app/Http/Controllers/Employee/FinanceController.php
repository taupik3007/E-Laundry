<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Carbon\Carbon;

class FinanceController extends Controller
{
    function index(){
        $todayIncome = Payment::whereDate('pym_paid_at', Carbon::today())
            ->sum('pym_amount');
            $monthIncome = Payment::where('pym_payment_status', 1)
    ->whereMonth('pym_paid_at', now()->month)
    ->whereYear('pym_paid_at', now()->year)
    ->sum('pym_amount');

        return view('employee.finance.index',compact(['todayIncome','monthIncome']));
    }
}
