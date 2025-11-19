<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\PriceService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PriceServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $PriceService = PriceService::all();
        $title = 'Delete Price Service!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('employee.price_service.index',compact('PriceService'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employee.price_service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    // Bersihkan format rupiah
    $cleanPrice = preg_replace('/[^0-9]/', '', $request->prs_price);

    // Pastikan nilainya tidak kosong
    if ($cleanPrice === '' || $cleanPrice === null) {
        return back()->withErrors(['prs_price' => 'Harga paket tidak boleh kosong'])->withInput();
    }

        $CreatePrice = PriceService::create([
            'prs_package' => $request->prs_package,
            'prs_price' => $cleanPrice,
        ]); 

        Alert::success('Berhasil Menambah', 'Berhasil menambah data harga');
        return redirect('/employee/price-service');
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
        $EditPrice = PriceService::findOrFail($id);
        return view('employee.price_service.edit', compact('EditPrice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    $cleanPrice = preg_replace('/[^0-9]/', '', $request->prs_price);
    if ($cleanPrice === '' || $cleanPrice === null) {
        return back()->withErrors(['prs_price' => 'Harga paket tidak boleh kosong'])->withInput();
    }
    $priceService = PriceService::findOrFail($id);

    $priceService->update([
        'prs_package' => $request->prs_package,
        'prs_price' => $cleanPrice,
    ]);

    // dd($priceService);
    Alert::success('Berhasil Mengubah', 'Berhasil mengubah data harga');
    return redirect('/employee/price-service');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $DestroyPrice = PriceService::findOrFail($id);
        //dd ($destroyScopeCategories);
        $DestroyPrice->delete();

        Alert::success('Berhasil Menghapus', 'Berhasil Menghapus data harga');
        return redirect('/employee/price-service');
    }
}
