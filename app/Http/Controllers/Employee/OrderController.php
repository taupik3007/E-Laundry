<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LaundryPackage;
use Illuminate\Http\Request;
use App\Models\LaundryService;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderlist = Order::with(['service', 'package'])
        ->get();
        return view('employee.order-laundry.index', compact('orderlist'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $laundryService = LaundryService::all();
        return view('employee.order-laundry.create',compact(['laundryService']));
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'ord_status' => 'required|string'
    ]);

    $order = Order::findOrFail($id);
    $order->ord_status = $request->ord_status;
    $order->save();

    return response()->json([
        'success' => true,
        'message' => 'Status pesanan berhasil diperbarui!',
        'status' => $order->ord_status,
    ]);

}

public function updateWeight(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $package = LaundryPackage::find($order->ord_packages_id);

    $order->ord_quantity = $request->ord_quantity;
    $order->ord_total  = $package->ldp_price * $request->ord_quantity;

    $order->save();

    // dd($order);

    return back()->with('success', 'Berat & harga berhasil diperbarui.');
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
        return view('employee.order-laundry.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function history()
    {
        return view('employee.order-laundry.history');
    }

    public function detail()
    {
        return view('employee.order-laundry.detail');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
