<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = User::role('customer')->get();
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);
        return view('employee.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
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
         $customer = User::findOrFail($id); // gunakan $customer
    return view('owner.customers.edit', compact('customer'));
    }


public function update(Request $request, string $id)
{
    $customer = User::findOrFail($id);

    $request->validate([
        'usr_name' => 'required|string|max:255',
        'usr_email' => 'required|email|unique:users,usr_email,' . $id . ',usr_id',
        'usr_nik' => 'required|string|max:255',
        'usr_birthplace' => 'required|string|max:255',
        'usr_birthdate' => 'required|date',
        'usr_gender' => 'required|string|max:255',
        'usr_religion' => 'required|string|max:255',
        'usr_telephone' => 'required|string|max:255',
    ]);


    $customer->update([
        'usr_name' => $request->usr_name,
        'usr_email' => $request->usr_email,
        'usr_nik' => $request->usr_nik,
        'usr_birthplace' => $request->usr_birthplace,
        'usr_birthdate' => $request->usr_birthdate,
        'usr_gender' => $request->usr_gender,
        'usr_religion' => $request->usr_religion,
        'usr_telephone' => $request->usr_telephone,
    ]);

    Alert::success('Berhasil Menghapus', 'Berhasil menghapus data Paket Layanan');
    return redirect()->route('customers.index')->with('success', 'Data customer berhasil diperbarui!');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function toggleStatus(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->usr_status = $request->usr_status;
    $user->save();

    return response()->json(['success' => true]);
}

}
