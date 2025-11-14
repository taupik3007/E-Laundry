<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaundryService extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'laundry_services';
    protected $primaryKey = 'lds_id';
    protected $guarded = [];

    const CREATED_AT = 'lds_created_at';
    const UPDATED_AT = 'lds_updated_at';
    const DELETED_AT = 'lds_deleted_at';

    public function packages()
{
    return $this->hasMany(LaundryPackage::class, 'ldp_service_id', 'lds_id');
}

}
