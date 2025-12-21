<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LaundryPackage;
use Illuminate\Http\Request;
use App\Models\LaundryService;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\User;
use Midtrans\Config;
use Midtrans\CoreApi; 
use Midtrans\Snap;  
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use RealRashid\SweetAlert\Facades\Alert;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderlist = Order::with(['service', 'package'])
    ->whereNotIn('ord_status', ['selesai', 'dibatalkan', 'belum lunas'])
    ->orderBy('ord_created_at', 'DESC')
    ->get();
    // dd($orderlist);


        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('employee.order-laundry.index', compact('orderlist'));
    }

    /**
     * Show the form for creating a new resource.
     */

     public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $order->ord_status = strtolower($request->ord_status);
    $order->save();

    $options = [];

    switch ($order->ord_status) {
        case 'menunggu penjemputan':
            $options = ['dalam penjemputan', 'dibatalkan'];
            break;

        case 'proses':
            $options = $order->ord_delivery_method == 'delivery'
                ? ['menunggu pengantaran']
                : ['menunggu pengambilan'];
            break;

        case 'menunggu pengantaran':
            $options = ['dalam pengantaran'];
            break;

        case 'dalam pengantaran':
        case 'menunggu pengambilan':
            $options = ['selesai'];
            break;
    }

    return response()->json([
        'success' => true,
        'status'  => $order->ord_status,
        'options' => $options,
        'paid'    => $order->payment && $order->payment->pym_payment_status == 1,
        'is_debt' => $order->payment && $order->payment->pym_is_debt == 1,
        'debt_amount' => $order->payment?->pym_debt_amount ?? 0,
    ]);
}

     

public function updateWeight(Request $request, $id)
{
    $order = Order::with('details.package')->findOrFail($id);

    $details = $request->input('details', []);

    $grandTotal = 0;

    foreach ($order->details as $detail) {

        // Ambil qty baru
        $newQty = $details[$detail->odt_id]['odt_quantity'] ?? $detail->odt_quantity;

        // Update quantity
        $detail->odt_quantity = $newQty;

        // Harga tetap ambil dari package
        $price = $detail->package->ldp_price;

        // Hitung ulang total per item
        $detail->odt_total = $price * $newQty;

        $detail->save();

        // Tambah ke grand total
        $grandTotal += $detail->odt_total;
    }

    // Simpan grand total ke tabel orders
    $order->ord_total = $grandTotal;
    $order->update([
        'ord_status' => 'proses'
    ]);
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
        $date = now()->format('Y-m-d'); // 2025-11-29
        $year = now()->format('Y');     // 2025
        $month = now()->format('m');    // 11
        $day = now()->format('d');
        $orderCountToday = Order::whereDate('ord_created_at', now())->count() + 1;
        $sort =  str_pad($orderCountToday, 3, '0', STR_PAD_LEFT);
        $invoice = "INV-{$year}{$month}{$day}-{$sort}";
        
        if ($request->ord_customer_id) {
            $user = User::find($request->ord_customer_id);
    
            $customerId = $user->usr_id;
            $customerName = $user->usr_name;
        } else {
            $customerId = null;
            $customerName = $request->ord_customer_name;
        }
    
        $package = LaundryPackage::find($request->package_id);
        // $total = $package->ldp_price * $request->quantity;
        $order = Order::create([
            'ord_customer_id'  => $customerId,
            'ord_customer_name'=> $customerName,
            'ord_phone_number' => $request->ord_phone_number,
            'ord_invoice' => $invoice,
            // 'ord_service_id' => $request->service_id,
            // 'ord_packages_id' => $request->package_id,
            // 'ord_quantity' => $request->quantity ?? null,
            'ord_delivery_method' => $request->delivery_method,
            'ord_address' => $request->address ?? null,
            'ord_status'  => 'proses',
            'ord_note' => $request->note ?? null,
            // 'ord_total' => $total ?? null,
        ]);
        // $order = Order::findOrfail($order->ord_id);
        // dd($order);

       
         // 3. Ambil semua array detail
    $services = $request->service_id;
    $packages = $request->package_id;
    $quantities = $request->quantity;

    $grandTotal = 0;

    foreach ($services as $i => $service) {

        $package = LaundryPackage::find($packages[$i]);

        $qty = $quantities[$i];
        $price = $package->ldp_price;
        $total = $qty * $price;

        // simpan detail
        OrderDetail::create([
            'odt_order_id' => $order->ord_id,
            'odt_service_id' => $service,
            'odt_package_id' => $packages[$i],
            'odt_quantity' => $qty,
            'odt_price' => $price,
            'odt_total' => $total,
        ]);

        $grandTotal += $total;
    }

    // 4. update total order
    $order->update([
        'ord_total' => $grandTotal,
        'ord_status' => 'proses'
    ]);


     // dd($request->ord_customer_id, $customerId, $customerName);
        $token = env('FONNTE_TOKEN'); // Taruh token di .env
        $packageText = '';
$no = 1;
        foreach ($order->details as $detail) {
         $packageText .= $no . ". "
        . $detail->package->ldp_name 
        . " x" . $detail->odt_quantity
        . " - Rp " . number_format($detail->odt_total, 0, ',', '.')
        . "\n";
        $no++;
        }
        // dd($order->ord_total);
        $message = "*INFORMASI PESANAN*\n\n"
    . "Invoice: *{$order->ord_invoice}*\n"
    . "Rincian\n\n"
    . $packageText . "\n"
    . "Total: *Rp {$order->ord_total}*\n\n"
    . "Pesanan Anda sedang diproses. Terima kasih telah Mempercayakan kepada Garut Laundry ";
        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => $order->ord_phone_number,
            'message' => $message,
            'countryCode' => '62',
        ]);

        if ($response->failed()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengirim pesan',
                'error' => $response->body()
            ], 500);
        }


        // return response()->json([
        //     'status' => true,
        //     'data' => $response->json()
        // ]);
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
     // Filter tanggal jika ada input
     if ($request->start_date && $request->end_date) {
        $query->whereBetween('ord_created_at', [
            $request->start_date . " 00:00:00",
            $request->end_date . " 23:59:59"
        ]);
    }
    
    $orderHistory = $query->orderBy('ord_created_at', 'desc')->get();

    
        // request AJAX → return rows only
        if ($request->ajax()) {
            return view('employee.order-laundry.history-table', compact('orderHistory'))->render();
        }
    
        return view('employee.order-laundry.history', compact('orderHistory'));
    }
    

    public function detail($id)
    {
        $order = Order::with(['service', 'package'])
        ->where('ord_id', $id)
        ->firstOrFail();
        return view('employee.order-laundry.detail', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

    if (!in_array($order->ord_status, ['menunggu penjemputan', 'dalam penjemputan', 'menunggu penyerahan'])) {
        Alert::error('Gagal', 'Pesanan tidak bisa dibatalkan.');
        return redirect()->back();
    }

    $order->update([
        'ord_status' => 'dibatalkan'
    ]);

    Alert::success('Berhasil', 'Pesanan berhasil dibatalkan.');
    return redirect()->back();
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
        return redirect()->to("/employee/ordering/{$order->ord_id}/qris-payment");
    }

    // ======================== ||
    // CASE CASH / TRANSFER     ||
    // ======================== ||

    $amount = preg_replace('/[^0-9]/', '', $request->payment_amount);
    $receive = (int) preg_replace('/[^0-9]/', '', $request->payment_amount);
    
    
    $paid   = $order->ord_total;
    if($amount >= $paid ){
        $amount = $paid;
    }

    $change = max(0, $receive - $paid);
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
        'pym_cash_received' => $receive,
        'pym_change_amount' => $change,
        'pym_paid_at' => now(),
        'pym_expiry_time' => now(),
        'pym_raw_response' => '-',
        'pym_sys_note' => 'Transaksi manual',
        'pym_created_by' => auth()->id(),
    ]);

    if ($cashback < 0) {
        $payment->pym_debt_amount = abs($cashback); // simpan utang
        $payment->pym_is_debt = true;

        //  $order->update([
        //      'ord_status' => 'Belum Lunas'
        // ]);

    } else {
        $payment->pym_debt_amount = 0;
        $payment->pym_is_debt = false;
        if (in_array($order->ord_status, [
            'menunggu pengambilan',
            'dalam pengantaran'
        ])) {
            $order->update([
                'ord_status' => 'selesai'
            ]);
        }

        // dd($order);
         $token = env('FONNTE_TOKEN'); // Taruh token di .env
        $packageText = '';
$no = 1;
        foreach ($order->details as $detail) {
         $packageText .= $no . ". "
        . $detail->package->ldp_name 
        . " x" . $detail->odt_quantity
        . " - Rp " . number_format($detail->odt_total, 0, ',', '.')
        . "\n";
        $no++;
        }
        // dd($order->ord_total);
        $message = "*PESANAN SELESAI*\n\n"
    . "Invoice: *{$order->ord_invoice}*\n"
    . "Rincian\n\n"
    . $packageText . "\n"
    . "Total: *Rp {$order->ord_total}*\n\n"
    . "Pesanan Anda Telah Selesai. Terima kasih telah Mempercayakan kepada Garut Laundry ";
        $response = Http::withHeaders([
            'Authorization' => $token,
        ])->post('https://api.fonnte.com/send', [
            'target' => preg_replace('/[^0-9]/', '', $order->ord_phone_number),
            'message' => $message,
            'countryCode' => '62',
        ]);

        if ($response->failed()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengirim pesan',
                'error' => $response->body()
            ], 500);
        }
           
        
    }

    // UPDATE STATUS ORDER
    $payment->pym_payment_status = $cashback >= 0;
    $payment->save();
    //  dd($payment);
    
// REDIRECT BERDASARKAN STATUS HUTANG
// if ($cashback < 0) {
//     return redirect()->to("/employee/debt")
//         ->with('warning', 'Pembayaran kurang, silakan selesaikan piutang!');
// } else {
//     return redirect()->to("/employee/ordering/history")
//         ->with('success', 'Pembayaran selesai!');
// }

return redirect()->back()->with(
    $cashback < 0 ? 'warning' : 'success',
    $cashback < 0
        ? 'Pembayaran kurang, masuk piutang'
        : 'Pembayaran berhasil'
);

  
}

public function receipt($id){
     $payment = Payment::with('order', 'order.customer')->findOrFail($id);
        $order = Order::with(['service', 'package'])
        ->where('ord_id', $id)
        ->firstOrFail();
    
        return view('employee.order-laundry.payment-receipt', compact('payment', 'order'));
    // $payment = Payment::with('order', 'order.customer')->findOrFail($id);

    // return view('', compact('payment'));
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
        $order->load('payment');

        // update order
        if (
            in_array($order->ord_status, [
                'menunggu pengambilan',
                'dalam pengantaran'
            ])
        ) {
            $order->update([
                'ord_status' => 'Selesai'
            ]);
        }
        // $order->update([
        //     'ord_status' => 'Selesai'
        // ]);

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
public function qrispayment($id)
{
    // Ambil data order
    $order = Order::findOrFail($id);

    // Ambil payment khusus QRIS (method = 3)
    $payment = Payment::where('pym_order_id', $order->ord_id)
        ->where('pym_order_method', 3) // QRIS
        ->latest()
        ->firstOrFail();

    return view('employee.order-laundry.qris-payment', [
        'order' => $order,
        'payment' => $payment,
        'qris' => $payment->pym_qrcode_url,
    ]);
}
public function callback(Request $request)
{
   $notif = $request->all();

    $payment = Payment::where('pym_gateaway_references', $notif['order_id'])->first();

    if (!$payment) {
        return response()->json(['message' => 'Payment not found'], 404);
    }

    $status = $notif['transaction_status'];

    if ($status == 'settlement') {

        // Update payment
        $payment->update([
            'pym_payment_status' => 1,
            'pym_paid_at' => now(),
        ]);

        // Update order
        $payment->order->update([
            'ord_status' => 'Selesai'
        ]);
    }

    return response()->json(['message' => 'Callback OK']);
}





}
