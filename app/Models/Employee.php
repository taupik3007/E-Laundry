<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = [ 'nama', 'tempat_lahir', 'tempat_lahir', 
    'jenis_kelamin', 'agama', 'alamat', 'rt', 'rw', 'desa', 'kecamatan',
    'kabupaten', 'provinsi', 'kode_pos', 'no_telepon'];
}
