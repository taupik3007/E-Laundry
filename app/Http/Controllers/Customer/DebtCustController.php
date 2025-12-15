<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\ReceivablePayments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DebtCustController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $debts = Payment::with('order')
        ->whereHas('order', function($q){
            $q->where('ord_customer_id', auth()->user()->usr_id);
        })
        ->where('pym_is_debt', 1)
        ->get();

    return view('customer.debt.index', compact('debts'));
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
    public function history(Request $request)
    {
        // $customerId = Auth::user()->id; 
        // kalau pakai tabel customer sendiri:
        // $customerId = Auth::user()->customer_id;

        $query = ReceivablePayments::with([
            'order.customer',
            'order.payment'
        ])
        ->whereHas('order', function($q){
            $q->where('ord_customer_id', auth()->user()->usr_id);
        });

        // filter tanggal cicilan
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('rp_paid_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $history = $query
            ->orderBy('rp_paid_at', 'desc')
            ->get();

        return view('customer.debt.history', compact('history'));
    }
}
