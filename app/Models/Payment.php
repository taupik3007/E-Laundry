<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'payments';
    protected $primaryKey = 'pym_id';
    protected $guarded = [];

    const CREATED_AT = 'pym_created_at';
    const UPDATED_AT = 'pym_updated_at';
    const DELETED_AT = 'pym_deleted_at';

    public function order()
{
    return $this->belongsTo(Order::class, 'pym_order_id', 'ord_id');
}

public function getMethodNameAttribute()
{
    return [
        1 => 'Cash',
        2 => 'Transfer',
        3 => 'QRIS'
    ][$this->pym_order_method] ?? '-';
}

}
