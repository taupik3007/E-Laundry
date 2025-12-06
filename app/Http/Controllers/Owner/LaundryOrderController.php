<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\LaundryPackage;
use Illuminate\Http\Request;
use App\Models\LaundryService;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Midtrans\Config;
use Midtrans\CoreApi; 

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
        ->where('ord_status', '!=', 'belum lunas')
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
    
            if ($request->start_date && $request->end_date) {
                $query->whereBetween('ord_updated_at', [
                    $request->start_date . " 00:00:00",
                    $request->end_date . " 23:59:59"
                ]);
            }
            
            $orderHistory = $query->orderBy('ord_updated_at', 'desc')->get();
    
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
         $order = Order::findOrFail($id);
    
        // Tentukan method
        $method = match($request->payment_method) {
            'cash' => 1,
            'transfer' => 2,
            default => 3 // qris
        };
    
        // CASE QRIS → MIDTRANS OTOMATIS
        if ($method == 3) 
        {
            // 1. SETUP MIDTRANS
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = false;
            // Config::$isSanitized = true;
            // Config::$is3ds = true;
    
            // 2. DATA TRANSAKSI
            $params = [
        "payment_type" => "qris",
        "transaction_details" => [
            "order_id" => "PAY-" . $order->ord_id . "-" . time(),
            "gross_amount" => $order->ord_total,
        ]
    ];
    
            // 3. REQUEST KE MIDTRANS
            $response = CoreApi::charge($params);
            // dd($snap);
    
            // QR CODE URL MIDTRANS
            $qrisUrl = $response->actions[0]->url;
            // dd($qrisUrl);
    
            // 4. SIMPAN PAYMENT STATUS → pending
            Payment::create([
                'pym_order_id' => $order->ord_id,
                'pym_order_method' => 3,
                'pym_payment_gateaway' => 'midtrans',
                'pym_gateaway_references' => $params['transaction_details']['order_id'],
                'pym_qrcode_url' => $qrisUrl,
                'pym_payment_status' => false, // masih pending
                'pym_amount' => $order->ord_total,
                'pym_amount_paid' => 0,
                'pym_paid_at' => null,
                'pym_expiry_time' => now()->addMinutes(15),
                'pym_raw_response' => json_encode($response),
                'pym_sys_note' => 'Menunggu pembayaran QRIS Midtrans',
                'pym_created_by' => auth()->id(),
            ]);
    
            // 5. TAMPILKAN HALAMAN QRIS
            return redirect()->to("/owner/ordering/{$order->ord_id}/qris-payment");
        }
    
        // ======================== ||
        // CASE CASH / TRANSFER     ||
        // ======================== ||
    
        $amount = preg_replace('/[^0-9]/', '', $request->payment_amount);
        $paid   = $order->ord_total;
    
        $cashback = $amount - $paid;
    
        $payment = Payment::create([
            'pym_order_id' => $order->ord_id,
            'pym_order_method' => $method,
            'pym_payment_gateaway' => 'manual',
            'pym_gateaway_references' => '-',
            'pym_qrcode_url' => '-',
            'pym_payment_status' => true,
            'pym_amount' => $amount,
            'pym_amount_paid' => $paid,
            'pym_paid_at' => now(),
            'pym_expiry_time' => now(),
            'pym_raw_response' => '-',
            'pym_sys_note' => 'Transaksi manual',
            'pym_created_by' => auth()->id(),
        ]);
    
        if ($cashback < 0) {
            $payment->pym_debt_amount = abs($cashback); // simpan utang
            $payment->pym_is_debt = true;
    
            $order->update([
                'ord_status' => 'Belum Lunas'
            ]);
    
        } else {
            $payment->pym_debt_amount = 0;
            $payment->pym_is_debt = false;
            $payment->pym_payment_status = 1;
            $order->update([
                'ord_status' => 'selesai'
            ]);
        }
    
        // UPDATE STATUS ORDER
        $payment->pym_payment_status = $cashback >= 0;
        $payment->save();
        //  dd($payment);
        return redirect('owner/ordering/history');
      
    }

    public function ajaxPackages($id)
    {
        $packages = LaundryPackage::where('ldp_service_id', $id)->get();
    
        return response()->json($packages);
    }
    
}
