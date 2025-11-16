<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\LaundryPackage;
use App\Models\LaundryService;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LaundryPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($serviceId)
    {
         $service = LaundryService::findOrFail($serviceId);
         $packages = LaundryPackage::where('ldp_service_id', $serviceId)->get();
         $title = 'Delete User!';
         $text = "Are you sure you want to delete?";
         confirmDelete($title, $text);
         return view('employee.laundry-package.index', compact('service', 'packages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($serviceId)
    {
        $service = LaundryService::findOrFail($serviceId);
        return view('employee.laundry-package.create', compact('service'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $serviceId)
    {
        
        $cleanPrice = preg_replace('/[^0-9]/', '', $request->ldp_price);
        $CreatePackage = LaundryPackage::create([
            'ldp_service_id' => $serviceId,
            'ldp_name' => $request->ldp_name,
            'ldp_price' => $cleanPrice,
            'ldp_description' => $request->ldp_description,
            'ldp_duration' => $request->ldp_duration,
            'ldp_created_by' => auth()->id(),
        ]);

        Alert::success('Berhasil Menambah', 'Berhasil menambah data Paket Layanan');
        // dd($CreatePackage);
        return redirect()->route('package.index', $serviceId)->with('success', 'Paket berhasil ditambahkan!');
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
    public function edit($serviceId, $packageId)
    {
        $service = LaundryService::findOrFail($serviceId);
        $package = LaundryPackage::findOrFail($packageId);

        return view('employee.laundry-package.edit', compact('service', 'package'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $serviceId, $packageId)
    {
        $cleanPrice = preg_replace('/[^0-9]/', '', $request->ldp_price);

        $package = LaundryPackage::findOrFail($packageId);
    
        $package->update([
            'ldp_name' => $request->ldp_name,
            'ldp_price' => $cleanPrice,
            'ldp_description' => $request->ldp_description,
            'ldp_duration' => $request->ldp_duration,
            'ldp_updated_by' => auth()->id(),
        ]);
    
        Alert::success('Berhasil Mengubah', 'Berhasil mengubah data Paket Layanan');
        return redirect()->route('package.index', $serviceId)
                         ->with('success', 'Paket berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($serviceId, $packageId)
    {
        $package = LaundryPackage::findOrFail($packageId);

    $package->delete();

    Alert::success('Berhasil Menghapus', 'Berhasil menghapus data Paket Layanan');
    return redirect()
        ->route('package.index', $serviceId)
        ->with('success', 'Paket berhasil dihapus!');
    }
    
    public function ajaxPackages($id)
{
    $packages = LaundryPackage::where('ldp_service_id', $id)->get();

    return response()->json($packages);
}

}
