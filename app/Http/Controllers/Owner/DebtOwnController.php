<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Payment;
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

    return redirect()->route('debt-own.index')->with('success', 'Pembayaran berhasil diperbarui!');

    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
