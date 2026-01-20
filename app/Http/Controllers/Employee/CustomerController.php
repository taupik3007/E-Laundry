<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\ReceivablePayments;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('employee.customers.create');
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
        $createCustomer->assignRole('customer');
        // dd( $createCustomer);
        Alert::success('Berhasil Menambah', 'Berhasil menambah data pelanggan');   
        return redirect('/employee/customers')->with('success', 'pelanggan berhasil ditambahkan!');
  
    }

    /**
     * Display the specified resource.
     */

     public function detail($id)
     {
        $user = User::findOrFail($id);
         return view('employee.customers.detail', compact('user'));
     }
    

    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::role('customer')->where('usr_id',$id)->first();
        return view('employee.customers.edit',compact(['user']));
    }


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
    // dd($user);
    Alert::success('Berhasil Mengubah', 'Berhasil mengubah data pegawai');

    return redirect('/employee/customers');

}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::where('usr_id', $id)->firstOrFail();

    if ($user->usr_status == 1) {
        Alert::error('Gagal Menghapus', 'Akun masih aktif dan tidak dapat dihapus');
        return redirect('/employee/customers');
    }
    // dd($user);
    $user->delete();

    Alert::success('Berhasil Menghapus', 'Berhasil menghapus data pelanggan');
    return redirect('/employee/customers');
    }


    public function toggleStatus(Request $request, $id)
{
    $user = User::findOrFail($id);
    $user->usr_status = $request->usr_status;
    $user->save();

    return response()->json(['success' => true]);
}

public function history(Request $request)
    {
        $customerId = Auth::user()->id; 
        // kalau pakai tabel customer sendiri:
        // $customerId = Auth::user()->customer_id;

        $query = ReceivablePayments::with([
            'order.customer',
            'order.payment'
        ])
        ->whereHas('order', function ($q) use ($customerId) {
            $q->where('ord_customer_id', $customerId);
        });

        // filter tanggal cicilan
        if ($request->start_date && $request->end_date) {
            $query->whereBetween('rp_paid_at', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        $history = $query
            ->orderBy('rp_paid_at', 'desc')
            ->get();

        return view('customer.receivables.history', compact('history'));
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

    return redirect('/employee/customers');
}

}


