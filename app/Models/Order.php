<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'orders';
    protected $primaryKey = 'ord_id';
    protected $guarded = [];

    const CREATED_AT = 'ord_created_at';
    const UPDATED_AT = 'ord_updated_at';
    const DELETED_AT = 'ord_deleted_at';

    public function package()
    {
        return $this->belongsTo(LaundryPackage::class, 'ord_packages_id', 'ldp_id');
    }

}
