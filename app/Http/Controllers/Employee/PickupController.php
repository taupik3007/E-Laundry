<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LaundryPackage;
use App\Models\LaundryService;
use App\Models\Order;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PickUpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = Order::all();
        return view('employee.pick-up.index', compact('order'));
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
        //
    }

    public function detail(string $id)
    {
        $order = Order::with(['package.service'])->findOrFail($id);
        return view('employee.pick-up.detail', compact('order'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);

    // Cek status, hanya bisa hapus jika status Selesai atau Dibatalkan
    if (!in_array($order->ord_status, ['Selesai', 'Dibatalkan'])) {
        return response()->json([
            'success' => false,
            'message' => '❌ Hanya pesanan dengan status Selesai atau Dibatalkan yang bisa dihapus.'
        ], 403);
    }

    // Hapus data
    $order->delete();
    Alert::success('Berhasil Menghapus', 'Berhasil menghapus data administrasi guru');

    return response()->json([
        'success' => true,
        'message' => '✅ Data penjemputan berhasil dihapus.'
    ]);
    }
}
