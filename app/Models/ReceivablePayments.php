<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivablePayments extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'receivable_payments';
    protected $primaryKey = 'rp_id';
    protected $guarded = [];

    const CREATED_AT = 'rp_created_at';
    const UPDATED_AT = 'rp_updated_at';
    const DELETED_AT = 'rp_deleted_at';

    public function order()
    {
        return $this->belongsTo(Order::class, 'rp_order_id', 'ord_id');
    }
}
