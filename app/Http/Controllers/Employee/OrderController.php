<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LaundryPackage;
use Illuminate\Http\Request;
use App\Models\LaundryService;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Midtrans\Config;
use Midtrans\CoreApi;   
use Carbon\Carbon;


class OrderController extends Controller
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
            'ord_status'  => 'proses',
            'ord_note' => $request->note ?? null,
            'ord_total' => $total ?? null,
        ]);
        // dd($request->ord_customer_id, $customerId, $customerName);
        return redirect('employee/ordering/');

    }

    public function pickup()
{
    $orders = Order::where('ord_pickup_method', 'delivery')
                   ->whereIn('ord_status', ['menunggu penjemputan', 'dalam penjemputan'])
                   ->get();

    return view('employee.orders.pickup', compact('orders'));
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
            return view('employee.order-laundry.history-table', compact('orderHistory'))->render();
        }
    
        return view('employee.order-laundry.history', compact('orderHistory'));
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

    public function payment(Request $request, $id)
{
    $order = Order::findOrFail($id);
    if ($request->payment_method == "qris") {
        $amount = $order->ord_total; // langsung full
    } else {
        $amount = preg_replace('/[^0-9]/', '', $request->payment_amount);
    }
    
    if ($request->payment_method == 'cash') {
        $method = 1;
    } elseif ($request->payment_method == 'transfer') {
        $method = 2;
    } else {
        $method = 3; // qris
    }
    
    // $amount = preg_replace('/[^0-9]/', '', $request->payment_amount);
    // dd($amount);

    // ===== INSERT KE PAYMENTS =====
    Payment::create([
        'pym_order_id'          => $order->ord_id,
        'pym_order_method'      => $method,
        'pym_payment_gateaway'  => 'manual',
        'pym_gateaway_references' => '-',
        'pym_qrcode_url'        => '-',
        'pym_payment_status'    => true,
        'pym_amount'            => $amount,
        'pym_amount_paid'       => $order->ord_total,
        'pym_paid_at'           => now(),
        'pym_expiry_time'       => now(),
        'pym_raw_response'      => '-',
        'pym_sys_note'          => 'Transaksi manual / offline',
        'pym_created_by'        => auth()->id(),
    ]);

    // ===== UPDATE STATUS ORDER =====
    if ($request->payment_method == 'cash') {
       $order->update([
        'ord_status' => 'Selesai'
    ]);

    } elseif ($request->payment_method == 'transfer') {
        $method = 2;
    } else {
        $method = 3; // qris
    }
    
    // dd('Payment');
    return redirect('employee/ordering/history');  
}

public function receipt(){
    return view('employee.order-laundry.payment-receipt');
}


    public function ajaxPackages($id)
    {
        $packages = LaundryPackage::where('ldp_service_id', $id)->get();
    
        return response()->json($packages);
    }

    public function processPayment(Request $request, $id)
{
     $order = Order::findOrFail($id);

    // Setup Midtrans
    Config::$serverKey     = config('midtrans.server_key');
    Config::$isProduction  = config('midtrans.is_production');
    Config::$isSanitized   = true;
    Config::$is3ds         = true;

    // ============== CASE CASH ===================
    if ($request->payment_method == 'cash') {

        $payment = Payment::create([
            'pym_order_id'          => $order->ord_id,
            'pym_order_method'      => 1,
            'pym_payment_gateaway'  => null,
            'pym_gateaway_references' => '-',
            'pym_qrcode_url'        => null,
            'pym_payment_status'    => 1, // sukses
            'pym_amount'            => $request->payment_amount,
            'pym_paid_at'           => Carbon::now(),
            'pym_expiry_time'       => null,
            'pym_raw_response'      => 'cash_payment',
        ]);

        // update order
        $order->update([
            'ord_payment_status' => 'paid',
        ]);

        return back()->with('success', 'Pembayaran cash berhasil');
    }

    // ============== CASE QRIS ===================
    $params = [
        "payment_type" => "qris",
        "transaction_details" => [
            "order_id"      => 'ORDER-' . $order->ord_id . '-' . time(),
            "gross_amount"  => $order->ord_total,
        ],
        "qris" => [
            "acquirer" => "gopay",
        ]
    ];

    $midtrans = CoreApi::charge($params);

    // Midtrans QRIS URL
    $qrisUrl = $midtrans->actions[0]->url ?? null;

    // Expiry time (jika ada)
    $expiry = isset($midtrans->expiry_time)
        ? Carbon::parse($midtrans->expiry_time)
        : Carbon::now()->addMinutes(30);

    // Simpan ke database
    Payment::create([
        'pym_order_id'          => $order->ord_id,
        'pym_order_method'      => 2,
        'pym_payment_gateaway'  => 'midtrans',
        'pym_gateaway_references' => $midtrans->transaction_id ?? '-',
        'pym_qrcode_url'        => $qrisUrl,
        'pym_payment_status'    => 0, // pending menunggu scan
        'pym_amount'            => $order->ord_total,
        'pym_paid_at'           => now(),
        'pym_expiry_time'       => $expiry,
        'pym_raw_response'      => json_encode($midtrans),
    ]);

    return back()->with('qris_url_'.$order->ord_id, $qrisUrl);
}
public function qrispayment($id){
    $payment = Payment::where('pym_order_id',$id)->first();
    // dd($payment);
    return view('employee.order-laundry.qris-payment',compact(['payment']));
}



}
