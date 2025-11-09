<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaundryPackage extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'laundry_packages';
    protected $primaryKey = 'ldp_id';
    protected $guarded = [];

    const CREATED_AT = 'ldp_created_at';
    const UPDATED_AT = 'ldp_updated_at';
    const DELETED_AT = 'ldp_deleted_at';

    public function service()
    {
        return $this->belongsTo(LaundryService::class, 'ldp_service_id', 'lds_id');
    }
}
