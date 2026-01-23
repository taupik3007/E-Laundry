<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use RealRashid\SweetAlert\Facades\Alert;

class CustomersController extends Controller
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
        return view('owner.customers.index', compact('customers'));
    }
    public function toggleStatus($id){
        $user = User::findOrFail($id);
        if($user->usr_status == 1){
            $user->update(['usr_status'=>0]);
        }else{
            $user->update(['usr_status'=>1]);

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('owner.customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'usr_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            // 'usr_telephone' => 'required|numeric|digits_between:10,15',
            'usr_address' => 'required|string|max:100',
            'password' => 'required|string|min:6',
        ], [
        
            'usr_name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan.',
            // 'usr_telephone.required' => 'Nomor telepon wajib diisi.',
            // 'usr_telephone.numeric' => 'Nomor telepon hanya boleh angka.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
        ]);
        // dd($validated);
    
        $telephone = preg_replace('/\D/', '', $request->usr_telephone);

        if (!str_starts_with($telephone, '0')) {
            $telephone = '0' . $telephone;
        }
        
        // dd($validated);
       $createCustomer = User::create([
            'usr_name' => $validated['usr_name'],
            'email' => $validated['email'],
            'usr_telephone' => $telephone,
            'usr_address' => $validated['usr_address'],
            'password' => bcrypt($validated['password']),
            'usr_status' => 1,       
        ]);
        // dd($createCustomer);
        $createCustomer->assignRole('customer');
        // dd( $createCustomer);
        Alert::success('Berhasil Menambah', 'Berhasil menambah data pelanggan');   
        return redirect('/owner/customer')->with('success', 'pelanggan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */

     public function detail($id)
     {
        $user = User::findOrFail($id);
         return view('owner.customers.detail', compact('user'));
     }
    
    public function edit(string $id)
    {
        $user = User::role('customer')->where('usr_id',$id)->first();
        return view('owner.customers.edit',compact(['user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

    $validated = $request->validate([
        'usr_name' => 'required|string|max:100',
        'email' => 'required|email|unique:users,email,' . $user->usr_id . ',usr_id',
        // 'usr_telephone' => 'required|numeric|digits_between:10,15',
        'usr_address' => 'required|string|max:100',
    ], [
        'usr_name.required' => 'Nama wajib diisi.',
        'email.required' => 'Email wajib diisi.',
        'email.email' => 'Format email tidak valid.',
        'email.unique' => 'Email sudah digunakan.',
        // 'usr_telephone.required' => 'Nomor telepon wajib diisi.',
        // 'usr_telephone.numeric' => 'Nomor telepon hanya boleh angka.',
    ]);
    // dd($validated);

    $telephone = preg_replace('/\D/', '', $request->usr_telephone); 

    if (!str_starts_with($telephone, '0')) {
        $telephone = '0' . $telephone;
    }

    // Update data tanpa password
    $user->update([
        'usr_name' => $validated['usr_name'],
        'email' => $validated['email'],
        'usr_telephone' => $telephone,
        'usr_address' => $validated['usr_address'],
        // 'password' => bcrypt($validated['password']),
    ]);
    Alert::success('Berhasil Mengubah', 'Berhasil mengubah data pegawai');

    return redirect('/owner/customer');

    }

    public function edit_password(string $id)
    {
        $user = User::role('customer')->where('usr_id',$id)->first();
        return view('owner.customers.editpass',compact(['user']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_password(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('status', 'password-updated');
    Alert::success('Berhasil Mengubah', 'Berhasil mengubah data pegawai');

    return redirect('/owner/customer');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('usr_id', $id)->firstOrFail();

    if ($user->usr_status == 1) {
        Alert::error('Gagal Menghapus', 'Akun masih aktif dan tidak dapat dihapus');
        return redirect('/owner/customer');
    }
    // dd($user);
    $user->delete();

    Alert::success('Berhasil Menghapus', 'Berhasil menghapus data pelanggan');
    return redirect('/owner/customer');

    }

    public function changePassword(Request $request, $id)
{
    // Validasi
    $request->validate([
        'password' => 'required|min:6',
    ]);

    // Cari user
    $user = User::findOrFail($id);

    // Update password
    $user->password = bcrypt($request->password);
    // dd($user);
    $user->save();

    Alert::success('Berhasil Mengubah password', 'Berhasil mengubah password pegawai');

    return redirect('/owner/customer');
}
}
