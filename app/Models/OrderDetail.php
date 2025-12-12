<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'order_details';
    protected $primaryKey = 'odt_id';
    protected $guarded = [];

    const CREATED_AT = 'odt_created_at';
    const UPDATED_AT = 'odt_updated_at';
    const DELETED_AT = 'odt_deleted_at';

    public function package()
    {
        return $this->belongsTo(LaundryPackage::class, 'odt_package_id', 'ldp_id');
    }
    public function service()
    {
        return $this->belongsTo(LaundryService::class, 'odt_service_id', 'lds_id');
    }
}
