<?php

namespace App\Http\Controllers\Owner;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $employees = User::role('employee')->get();
        return view('owner.employee.index',['data_employee']);
    }
public function create() {
    return view('owner.employee.create'); 
}

public function store(Request $request) {
    Employee::create([
        'nama' => $request->nama,
        'tempat_lahir' => $request->tempat_lahir,
        'tanggal_lahir' => $request->tanggal_lahir,
        'jenis_kelamin' => $request->jenis_kelamin,
        'agama' => $request->agama,
        'alamat' => $request->alamat,
        'rt' => $request->rt,
        'rw' => $request->rw,
        'desa' => $request->desa,
        'kecamatan' => $request->kecamatan,
        'kabupaten' => $request->kabupaten,
        'provinsi' => $request->provinsi,
        'kode_pos' => $request->kode_pos,
        'no_telepon' => $request->no_telepon,
    ]);

    return redirect()->route('employee.index')->with('success', 'employee berhasil ditambahkan!');
}

    public function edit($id)
    {
        $employee = \App\Models\Employee::find($id);
        return view('owner/employee/edit',['employee' => $employee]);
    }

    public function update(Request $request, $id)
    {
        $employee = \App\Models\Employee::find($id);
        $employee->update($request->all());
        return redirect('/owner/employee')->with('sukses','Data berhasil di update');
    }

    public function delete($id)
    {
        $employee = \App\Models\Employee::find($id);
        $employee->delete();
        return redirect('/owner/employee')->with('sukses','Data berhasil di hapus');
    }
}
