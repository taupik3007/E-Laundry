<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\LaundryPackage;
use App\Models\LaundryService;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;


class OrderLaundryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderlist = Order::with(['service', 'package'])
        ->orderBy('ord_created_at', 'DESC')
        ->where('ord_customer_id', auth()->user()->usr_id)
        ->whereIn('ord_status', ['menunggu penjemputan', 'dalam penjemputan', 'menunggu penyerahan', 'proses',  'menunggu pengantaran', 'dalam pengantaran', 'menunggu pengambilan'])
        ->get();
        $title = 'Hapus Kegiatan Laundry!';
         $text = "Apakah Anda yakin ingin menghapus order laundry?";
         confirmDelete($title, $text);
        return view('customer.order-laundry.index', compact('orderlist'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = LaundryService::all();
        return view('customer.order-laundry.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    // dd('Masuk Store');
    // $package = LaundryPackage::find($request->package_id);
    // $total = $package->ldp_price * $request->quantity;

    // $request->validate([
    //     'ord_customer_id'   => 'required_without:ord_customer_name',
    //     'ord_customer_name' => 'required_without:ord_customer_id',
    // ]);
    $date = now()->format('Y-m-d'); // 2025-11-29
    $year = now()->format('Y');     // 2025
    $month = now()->format('m');    // 11
    $day = now()->format('d');
    $orderCountToday = Order::whereDate('ord_created_at', now())->count() + 1;
    $sort =  str_pad($orderCountToday, 3, '0', STR_PAD_LEFT);
    $invoice = "INV-{$year}{$month}{$day}-{$sort}";
    
    $user = auth('web')->user();

    if ($request->ord_customer_id) {
        $user = User::find($request->ord_customer_id);

        $customerId = $user->usr_id;
        $customerName = $user->usr_name;
    } else {
        $customerId = null;
        $customerName = $request->ord_customer_name;
    }

    $order = Order::create([
        'ord_customer_id'   => $user->usr_id,
        'ord_customer_name' => $user->usr_name,
        'ord_phone_number' => $request->ord_phone_number,
        'ord_invoice' => $invoice,
        // 'ord_service_id' => $request->service_id,
        // 'ord_packages_id' => $request->package_id,
        // 'ord_quantity' => $request->quantity ?? null,
        'ord_pickup_method' => $request->pickup_method,
        'ord_delivery_method' => $request->delivery_method,
        'ord_address' => $request->address ?? null,
        'ord_note' => $request->note ?? null,
        // 'ord_total' => $total ?? null,
    ]);

         // 3. Ambil semua array detail
         $services = $request->service_id;
         $packages = $request->package_id;
         $quantities = $request->quantity;
     
         $grandTotal = 0;
     
         foreach ($services as $i => $service) {
     
             $package = LaundryPackage::find($packages[$i]);
     
             $price = $package->ldp_price;
     
             // simpan detail
             OrderDetail::create([
                 'odt_order_id' => $order->ord_id,
                 'odt_service_id' => $service,
                 'odt_package_id' => $packages[$i],
                 'odt_price' => $price,
             ]);
    
         }     

    if ($request->pickup_method == 'delivery') {
        $order->ord_status = 'menunggu penjemputan';
    } else {
        $order->ord_status = 'menunggu penyerahan';
    }


    Alert::success('Berhasil Menambah', 'Berhasil menambah Orderan');
    // dd($order);
    return redirect('/customer/order-laundry');

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
    public function edit($id)
{
    $order = Order::with('details')->findOrFail($id);
    $services = LaundryService::all();

    return view('customer.order-laundry.edit', compact('order', 'services'));
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
{
    $order = Order::with('details')->findOrFail($id);

    // update data order utama (kalau ada)
    $order->update([
        'ord_phone_number'   => $request->ord_phone_number,
        'ord_pickup_method'  => $request->pickup_method,
        'ord_delivery_method'=> $request->delivery_method,
        'ord_address'        => $request->address,
        'ord_note'           => $request->note,
    ]);

    // HAPUS DETAIL LAMA
    $order->details()->delete();

    // SIMPAN DETAIL BARU
    foreach ($request->service_id as $i => $serviceId) {

        $package = LaundryPackage::find($request->package_id[$i]);

        OrderDetail::create([
            'odt_order_id'   => $order->ord_id,
            'odt_service_id' => $serviceId,
            'odt_package_id' => $request->package_id[$i],
            'odt_price'      => $package->ldp_price,
        ]);
    }

    Alert::success('Berhasil', 'Order berhasil diperbarui');
    return redirect('/customer/laundry-order');
}


    public function detail($id)
    {
        $order = Order::with(['service', 'package'])
        ->where('ord_id', $id)
        ->firstOrFail();
        
        return view('customer.order-laundry.detail-history', compact('order'));
    }
    public function detailorder($id)
    {
        $order = Order::with(['service', 'package'])
        ->where('ord_id', $id)
        ->firstOrFail();
        
        return view('customer.order-laundry.detail', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        Alert::success('Berhasil Dihapus', 'Order berhasil dihapus.');
        return redirect()->back();
    }

    public function history(Request $request)
{
    // $history = Order::where('ord_customer_id', auth()->id())
    //             ->whereIn('ord_status', ['selesai', 'dibatalkan'])
    //             ->orderBy('ord_id', 'DESC')
    //             ->get();
    $query = Order::where('ord_customer_id', Auth::id())
        ->whereIn('ord_status', ['selesai', 'dibatalkan'])
        ->with(['service', 'package']);

    // Filter tanggal jika ada input
    if ($request->start_date && $request->end_date) {
        $query->whereBetween('ord_created_at', [
            $request->start_date . " 00:00:00",
            $request->end_date . " 23:59:59"
        ]);
    }

    $history = $query->orderBy('ord_created_at', 'desc')->get();

    return view('customer.order-laundry.history', compact('history'));

}


    public function ajaxPackages($id)
{
    $packages = LaundryPackage::where('ldp_service_id', $id)->get();

    return response()->json($packages);
}

}
