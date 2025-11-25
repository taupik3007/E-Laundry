<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\LaundryPackage;
use Illuminate\Http\Request;
use App\Models\LaundryService;
use App\Models\Order;
use App\Models\User;

class LaundryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderlist = Order::with(['service', 'package'])
        ->where('ord_status', '!=', 'selesai')
        ->where('ord_status', '!=', 'dibatalkan')
        ->get();
        return view('owner.order-laundry.index', compact('orderlist'));
    }

    public function updateStatus(Request $request, $id)
{
    $request->validate([
        'ord_status' => 'required|string'
    ]);

    $order = Order::findOrFail($id);
    // $order->ord_status = $request->ord_status;
    switch ($order->ord_status) {

        case 'menunggu penjemputan':
            $order->ord_status = 'dalam penjemputan';
            break;

        case 'dalam penjemputan':
        case 'menunggu penyerahan':
            $order->ord_status = 'proses'; // ketika barang sudah tiba & timbang
            break;

        case 'Proses':
            if ($order->ord_delivery_method == 'delivery') {
                $order->ord_status = 'menunggu pengantaran';
            } else {
                $order->ord_status = 'menunggu pengambilan';
            }
            break;

        case 'menunggu pengantaran':
            $order->ord_status = 'dalam pengantaran';
            break;

        case 'dalam pengantaran':
        case 'menunggu diambil':
            $order->ord_status = 'selesai';
            break;
    }
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
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers = User::role('customer')->get();
        $services = LaundryService::all();
        return view('owner.order-laundry.create',compact(['services', 'customers']));
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
            'ord_status'  => 'proses',
            'ord_note' => $request->note ?? null,
            'ord_total' => $total ?? null,
        ]);
        // dd($request->ord_customer_id, $customerId, $customerName);
        return redirect('owner/ordering/');
    }

    public function pickup()
{
    $orders = Order::where('ord_pickup_method', 'delivery')
                   ->whereIn('ord_status', ['menunggu penjemputan', 'dalam penjemputan'])
                   ->get();

    return view('owner.orders.pickup', compact('orders'));
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
        return view('owner.order-laundry.edit');
    }

    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function history(Request $request)
    {
        $query = Order::with(['service', 'package'])
            ->whereIn('ord_status', ['Selesai', 'dibatalkan']);
    
        if ($request->year) {
            $query->whereYear('ord_created_at', $request->year);
        }
    
        if ($request->month) {
            $query->whereMonth('ord_created_at', $request->month);
        }
    
        $orderHistory = $query->get();
    
        // request AJAX → return rows only
        if ($request->ajax()) {
            return view('owner.order-laundry.history-table', compact('orderHistory'))->render();
        }
    
        return view('owner.order-laundry.history', compact('orderHistory'));
    }

    public function detail()
    {
        return view('owner.order-laundry.detail');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
public function payment(Request $request, $id)
{
    // $request->validate([
    //     'payment_method' => 'required',
    //     'payment_amount' => 'required|numeric',
    // ]);

    $order = Order::findOrFail($id);
    if ($request->payment_method == "qris") {
        $amount = $order->ord_total; // langsung full
    } else {
        $amount = preg_replace('/[^0-9]/', '', $request->payment_amount);
    }
    
    // Hitung kembalian
    $method = $request->method == 'cash' ? 1 : ($request->method == 'transfer' ? 2 : 3);
    $amount = preg_replace('/[^0-9]/', '', $request->payment_amount);

    // ===== INSERT KE PAYMENTS =====
    Payment::create([
        'pym_order_id'          => $order->ord_id,
        'pym_order_method'      => $method,
        'pym_payment_gateaway'  => 'manual',
        'pym_gateaway_references' => '-',
        'pym_qrcode_url'        => '-',
        'pym_payment_status'    => true,
        'pym_amount'            => $amount,
        'pym_paid_at'           => now(),
        'pym_expiry_time'       => now(),
        'pym_raw_response'      => '-',
        'pym_sys_note'          => 'Transaksi manual / offline',
        'pym_created_by'        => auth()->id(),
    ]);

    // ===== UPDATE STATUS ORDER =====
    $order->update([
        'ord_status' => 'Selesai'
    ]);

    // dd('Payment');
    return redirect('owner/ordering/');  

    // return redirect()->back()->with('success', 'Pembayaran berhasil diproses!');
}


    public function ajaxPackages($id)
    {
        $packages = LaundryPackage::where('ldp_service_id', $id)->get();
    
        return response()->json($packages);
    }
    
}
