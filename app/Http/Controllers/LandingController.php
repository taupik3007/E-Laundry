<?php

namespace App\Http\Controllers;

use App\Models\LaundryService;
use Illuminate\Http\Request;
use App\Models\Order;

class LandingController extends Controller
{
    public function index()
    {
        $services = LaundryService::with('packages')->get();// ambil layanan
        return view('landing', compact('services'));
    }

    public function tracking(Request $request)
    {
        // Kalau belum submit, tampilkan halaman input
        if (!$request->filled('invoice')) {
            return view('tracking.index');
        }

        $invoice = 'INV-' . $request->invoice;

        $order = Order::where('ord_invoice', $invoice)->first();

        if (!$order) {
            return view('tracking.index', [
                'error' => 'Pesanan tidak ditemukan'
            ]);
        }
        // dd($request);
        return view('tracking.index', compact('order'));
    }
}
