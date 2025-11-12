<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employee = User::role('employee')->get();
        return view('owner.employee.index', compact('employee'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
         return view('owner.employee.create');
    }

    
    public function store(Request $request)
    {
         $validated = $request->validate([
        'usr_name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email',
        'usr_telephone' => 'required|numeric|digits_between:10,15',
        'password' => 'required|string|min:6',
    ], [
    
        'usr_name.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        'usr_telephone.required' => 'Nomor telepon wajib diisi.',
        'usr_telephone.numeric' => 'Nomor telepon hanya boleh angka.',
        'password.required' => 'Password wajib diisi.',
        'password.min' => 'Password minimal 6 karakter.',
    ]);

    // dd($validated);
   $createEmployee = User::create([
        'usr_name' => $validated['usr_name'],
        'email' => $validated['email'],
        'usr_telephone' => $validated['usr_telephone'],
        'password' => bcrypt($validated['password']),
        'usr_role' => 'pegawai', 
        'usr_status' => 1,       
    ]);
    $createEmployee->assignRole('employee');

    return redirect('/owner/employee')->with('success', 'Pegawai berhasil ditambahkan!');
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
        $employee = User::role('employee')->where('usr_id',$id)->first();
        return view('owner.employee.edit',compact(['employee']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $employee = User::findOrFail($id);

    $validated = $request->validate([
        'usr_name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email,' . $employee->usr_id . ',usr_id',
        'usr_telephone' => 'required|numeric|digits_between:10,15',
    ], [
        'usr_name.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        'usr_telephone.required' => 'Nomor telepon wajib diisi.',
        'usr_telephone.numeric' => 'Nomor telepon hanya boleh angka.',
    ]);
    // dd($validated);

    // Update data tanpa password
    $employee->update([
        'usr_name' => $validated['usr_name'],
        'email' => $validated['email'],
        'usr_telephone' => $validated['usr_telephone'],
    ]);
     return redirect()->route('employee.index');

    }

    public function detail(Request $request, string $id)
    {
        // $detailuser =User::findOrFail($id); 
        return view('owner.employee.detail');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleteEmployee = User::findOrFail($id);
        $deleteEmployee->delete();
     return redirect()->route('employee.index');

    }
}
