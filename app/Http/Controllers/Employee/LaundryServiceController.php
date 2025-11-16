<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LaundryPackage;
use App\Models\LaundryService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LaundryServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $LaundryService = LaundryService::all();
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('employee.laundry-service.index', compact('LaundryService'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    return view('employee.laundry-service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lds_name' => 'required|string|max:255',
            'lds_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        // Simpan gambar ke folder storage/app/public/services
        $imagePath = $request->file('lds_image')->store('services', 'public');
    
        // Simpan ke database
        $CreateLaundry = LaundryService::create([
            'lds_name' => $request->lds_name,
            'lds_image' => $imagePath,
        ]);

        Alert::success('Berhasil Menambah', 'Berhasil menambah data Layanan Service');
        // dd($CreateLaundry);
        return redirect('/employee/laundry-service');
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
        $EditService = LaundryService::findOrFail($id);
        return view('employee.laundry-service.edit', compact('EditService'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    $service = LaundryService::findOrFail($id);

    if ($request->hasFile('lds_image')) {
        if ($service->lds_image && file_exists(storage_path('app/public/'.$service->lds_image))) {
            unlink(storage_path('app/public/'.$service->lds_image));
        }

        $imagePath = $request->file('lds_image')->store('service_images', 'public');
        $service->lds_image = $imagePath;
    }

    $service->lds_name = $request->lds_name;
    $service->save();

    Alert::success('Berhasil Mengubah', 'Berhasil mengubah data Layanan Service');
    //dd($service);
    return redirect()->route('laundry-service.index')
                     ->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         // cek apakah ada package yang memakai service ini
    $hasPackage = LaundryPackage::where('ldp_service_id', $id)->exists();

    if ($hasPackage) {
        Alert::error('Gagal Menghapus', 'Gagal menghapus data Layanan Service');
        return redirect()->back()->with('error', 'Layanan tidak dapat dihapus karena masih memiliki paket.');
    }

    $DeleteLaundry = LaundryService::where('lds_id', $id)->delete();
    // dd($DeleteLaundry);
    Alert::success('Berhasil Menghapus', 'Berhasil menghapus data Layanan Service');
    return redirect()->back()->with('success', 'Layanan berhasil dihapus.');
    }
}
