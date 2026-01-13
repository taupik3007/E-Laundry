<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discount = Discount::all();
        $title = 'Hapus Diskon!';
        $text = "Apakah Anda yakin ingin menghapus?";
        confirmDelete($title, $text);
        return view('owner.disc.index', compact('discount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.disc.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dsc_type'  => 'required|in:percent,nominal',
            'dsc_total' => [
                'required',
                'numeric',
                function ($attr, $value, $fail) use ($request) {
                    if ($request->dsc_type === 'percent' && $value > 100) {
                        $fail('Diskon persen tidak boleh lebih dari 100%.');
                    }
                }
            ],
        ]);

        $now = Carbon::now();

        // // LOGIKA STATUS OTOMATIS
        $status = ($now->between(
            Carbon::parse($request->dsc_start),
            Carbon::parse($request->dsc_finish)
        )) ? 1 : 0;
    
        $creatediscount = Discount::create([
            'dsc_name'       => $request->dsc_name,
            'dsc_type'       => $request->dsc_type,
            'dsc_total'      => $request->dsc_total,
            'dsc_start'      => $request->dsc_start,
            'dsc_finish'     => $request->dsc_finish,
            'dsc_status'     => $status,
            'dsc_created_by' => auth()->id(),
            'dsc_created_at' => now(),
        ]);
        Alert::success('Berhasil Menambah', 'Berhasil menambah data Layanan Service');
        // dd($creatediscount);
        return redirect('/owner/discount');
    
        
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
        $editdiskon = Discount::findOrFail($id);
        return view('owner.disc.edit', compact('editdiskon'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $discount = Discount::findOrFail($id);
        $request->validate([
            'dsc_type'  => 'required|in:percent,nominal',
            'dsc_total' => [
                'required',
                'numeric',
                function ($attr, $value, $fail) use ($request) {
                    if ($request->dsc_type === 'percent' && $value > 100) {
                        $fail('Diskon persen tidak boleh lebih dari 100%.');
                    }
                }
            ],
        ]);

        $now = Carbon::now();

        // LOGIKA STATUS OTOMATIS
        $status = ($now->between(
            Carbon::parse($request->dsc_start),
            Carbon::parse($request->dsc_finish)
        )) ? 1 : 0;
    
        $discount->update([
            'dsc_name'       => $request->dsc_name,
            'dsc_type'       => $request->dsc_type,
            'dsc_total'      => $request->dsc_total,
            'dsc_start'      => $request->dsc_start,
            'dsc_finish'     => $request->dsc_finish,
            'dsc_status'     => $status,
            'dsc_created_by' => auth()->id(),
            'dsc_created_at' => now(),
        ]);
        Alert::success('Berhasil Mengubah', 'Berhasil mengubah diskon');
        // dd($discount);
        return redirect('/owner/discount');
    
       
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $discount = Discount::findOrFail($id);

    // CEK STATUS DISKON
    if ($discount->dsc_status == 1) {
        Alert::error('Gagal Menghapus', 'Gagal menghapus diskon');
        return redirect()
            ->back()
            ->with('error', 'Diskon masih aktif dan tidak dapat dihapus.');
    }

    // BOLEH HAPUS JIKA NONAKTIF
    $discount->delete();
    Alert::success('Berhasil Menghapus', 'Berhasil menghapus diskon');
    return redirect()
        ->route('owner.disc.index')
        ->with('success', 'Diskon berhasil dihapus.');
    }
    public function updateStatusAjax()
{
    $now = Carbon::now();

    DB::table('discounts')->update([
        'dsc_status' => DB::raw("
            CASE
                WHEN '$now' BETWEEN dsc_start AND dsc_finish THEN 1
                ELSE 0
            END
        ")
    ]);

    return response()->json([
        'success' => true,
        'time' => $now->toDateTimeString()
    ]);
}
// public function syncStatus()
// {
//     DB::statement("SET time_zone = '+07:00'");

//     DB::table('discounts')->update([
//         'dsc_status' => DB::raw("
//             CASE
//                 WHEN NOW() BETWEEN dsc_start AND dsc_finish
//                 THEN 1 ELSE 0 END
//         ")
//     ]);

//     return response()->json([
//         'success' => true,
//         'now' => DB::selectOne('SELECT NOW() as now')->now
//     ]);
// }
public function syncStatus()
{
    DB::update("
        UPDATE discounts
        SET dsc_status =
            CASE
                WHEN NOW() BETWEEN dsc_start AND dsc_finish THEN 1
                ELSE 0
            END
    ");

    $discounts = Discount::select('dsc_id', 'dsc_status')->get();

    return response()->json([
        'success' => true,
        'data' => $discounts
    ]);
}

}
