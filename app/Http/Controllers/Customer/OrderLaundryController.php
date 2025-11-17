<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\LaundryPackage;
use App\Models\LaundryService;
use App\Models\Order;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class OrderLaundryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orderlist = Order::with(['service', 'package'])
        ->get();
        $title = 'Delete User!';
         $text = "Are you sure you want to delete?";
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
    $package = LaundryPackage::find($request->package_id);
    $total = $package->ldp_price * $request->quantity;

    $order = Order::create([
        'ord_phone_number' => $request->ord_phone_number,
        'ord_service_id' => $request->service_id,
        'ord_packages_id' => $request->package_id,
        'ord_quantity' => $request->quantity,
        'ord_pickup_method' => $request->pickup_method,
        'ord_delivery_method' => $request->delivery_method,
        'ord_address' => $request->address ?? null,
        'ord_total' => $total,
    ]);

    Alert::success('Berhasil Menambah', 'Berhasil menambah Orderan');
    // dd($CreateLaundry);
    return redirect('/customer/laundry-order');

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
        $order = Order::findOrFail($id);
        $services = LaundryService::all();
        $packages = LaundryPackage::where('ldp_service_id', $order->ord_service_id)->get();

        return view('customer.order-laundry.edit', compact('order', 'services', 'packages'));
    } 

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $UpdateOrder = Order::findOrFail($id);
        $package = LaundryPackage::find($request->package_id);
        $total = $package->ldp_price * $request->quantity;
        $UpdateOrder->update([
            'ord_phone_number' => $request->ord_phone_number,
            'ord_service_id' => $request->service_id,
            'ord_packages_id' => $request->package_id,
            'ord_quantity' => $request->quantity,
            'ord_pickup_method' => $request->pickup_method,
            'ord_delivery_method' => $request->delivery_method,
            'ord_address' => $request->address ?? null,
            'ord_total' => $total,
        ]);

        Alert::success('Berhasil Menambah', 'Berhasil menambah Orderan');
        // dd($CreateLaundry);
        return redirect('/customer/laundry-order');

    }

    public function detail($id)
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

    public function ajaxPackages($id)
{
    $packages = LaundryPackage::where('ldp_service_id', $id)->get();

    return response()->json($packages);
}

}
