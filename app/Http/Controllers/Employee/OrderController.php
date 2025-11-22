<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LaundryPackage;
use Illuminate\Http\Request;
use App\Models\LaundryService;
use App\Models\Order;
use App\Models\User;

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
    $order->ord_status  = "proses";


    $order->save();

    // dd($order);

    return back()->with('success', 'Berat & harga berhasil diperbarui.');
}

    public function create()
    {
        $customers = User::role('customer')->get();
        $services = LaundryService::all();
        return view('employee.order-laundry.create',compact(['services', 'customers']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'ord_customer_id'   => 'required_without:ord_customer_name',
            'ord_customer_name' => 'required_without:ord_customer_id',
        ]);
        
        if ($request->ord_customer_id) {
            $user = User::find($request->ord_customer_id);
    
            $customerId = $user->usr_id;
            $customerName = $user->usr_name;
        } else {
            $customerId = null;
            $customerName = $request->ord_customer_name;
        }
    
        $package = LaundryPackage::find($request->package_id);
        $total = $package->ldp_price * $request->quantity;
        $order = Order::create([
            'ord_customer_id'  => $customerId,
            'ord_customer_name'=> $customerName,
            'ord_phone_number' => $request->ord_phone_number,
            'ord_service_id' => $request->service_id,
            'ord_packages_id' => $request->package_id,
            'ord_quantity' => $request->quantity ?? null,
            'ord_delivery_method' => $request->delivery_method,
            'ord_address' => $request->address ?? null,
            'ord_note' => $request->note ?? null,
            'ord_total' => $total ?? null,
        ]);
        // dd($request->ord_customer_id, $customerId, $customerName);
        return redirect('employee/ordering/');

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

    public function ajaxPackages($id)
    {
        $packages = LaundryPackage::where('ldp_service_id', $id)->get();
    
        return response()->json($packages);
    }
}
