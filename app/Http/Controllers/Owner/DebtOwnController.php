<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\ReceivablePayments;
use Illuminate\Http\Request;

class DebtOwnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $debts = Payment::with('order', 'customer')
        ->where('pym_is_debt', 1)
        ->get();
return view('owner.debt.index', compact('debts'));
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
        $payment = Payment::findOrFail($id);

    // Ambil jumlah bayar dari input modal
    $amountPay = (int) str_replace(['Rp', '.', ','], '', $request->amount);

    // Tambah ke pym_amount_paid
    $payment->pym_amount += $amountPay;

    // Kurangi pym_debt_amount
    $payment->pym_debt_amount = max($payment->pym_debt_amount - $amountPay, 0);

    // Update status utang
    $payment->pym_is_debt = $payment->pym_debt_amount > 0 ? true : false;

    $payment->pym_payment_status = $payment->pym_debt_amount == 0 ? 1 : 0;

        // dd($payment);

    $payment->save();

    $order = $payment->order;  // relasi di model Payment
    if ($payment->pym_debt_amount == 0) {
        $order->ord_status = "selesai";
    } else {
        $order->ord_status = "Belum Lunas";
    }
    $order->save();

    ReceivablePayments::create([
        'rp_order_id'    => $order->ord_id,
        'rp_amount_paid' => $amountPay,
        'rp_remaining'   => $payment->pym_debt_amount,
        'rp_paid_at'     => now(),
        'rp_created_by'  => auth()->id(),
        'rp_sys_note'    => 'Pembayaran cicilan utang',
    ]);

    return redirect()->route('debt-own.index')->with('success', 'Pembayaran berhasil diperbarui!');

    }

    public function receipt($id){
        $payment = Payment::with('order', 'order.customer')->findOrFail($id);
        $order = Order::with(['service', 'package'])
        ->where('ord_id', $id)
        ->firstOrFail();
    
        return view('owner.debt.receipt', compact('payment', 'order'));
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
        // 1. query builder dulu (BELUM get)
    $query = ReceivablePayments::with([
        'order.customer',
        'order.payment'
    ]);

    // 2. filter tanggal (PAKAI rp_paid_at)
    if ($request->start_date && $request->end_date) {
        $query->whereBetween('rp_paid_at', [
            $request->start_date . ' 00:00:00',
            $request->end_date . ' 23:59:59'
        ]);
    }

    // 3. baru get
    $history = $query
        ->orderBy('rp_paid_at', 'desc')
        ->get();

    return view('owner.debt.history', compact('history'));
        // $query = ReceivablePayments::with([
        //     'order.customer',
        //     'order.payment'
        // ])
        // ->orderBy('rp_paid_at', 'desc')
        // ->get();

        // if ($request->start_date && $request->end_date) {
        //     $query->whereBetween('ord_created_at', [
        //         $request->start_date . " 00:00:00",
        //         $request->end_date . " 23:59:59"
        //     ]);
        //     $history = $query->orderBy('ord_created_at', 'desc')->get();
        // }
        
    
        // return view('employee.receivables.history',compact('history'));
        
    }
}
