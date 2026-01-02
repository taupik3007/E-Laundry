<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class FinancesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    function index(Request $request){
        $todayIncome = Payment::whereDate('pym_paid_at', Carbon::today())
        ->where('pym_amount', '>', 0)      // sudah ada pembayaran
        ->sum('pym_amount');
  
    
    $monthIncome = Payment::where('pym_amount', '>', 0) 
        ->whereMonth('pym_paid_at', now()->month)
        ->whereYear('pym_paid_at', now()->year)
        ->sum('pym_amount');
  
    // Semua Payment (history), termasuk yang masih hutang
    $payments = Payment::with(['order'])
        ->when($request->start_date && $request->end_date, function ($query) use ($request) {
            $query->whereBetween('pym_paid_at', [
                $request->start_date . " 00:00:00",
                $request->end_date . " 23:59:59"
            ]);
        })
        ->orderBy('pym_paid_at', 'DESC')
        ->get();
  
    return view('owner.finance.index', compact(
        'todayIncome',
        'monthIncome',
        'payments'
    ));
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
