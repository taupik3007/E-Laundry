<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PriceService extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'price_services';
    protected $primaryKey = 'prs_id';
    protected $guarded = [];

    const CREATED_AT = 'prs_created_at';
    const UPDATED_AT = 'prs_updated_at';
    const DELETED_AT = 'prs_deleted_at';

    public function setPrsPriceAttribute($value)
    {
        $this->attributes['prs_price'] = str_replace(['Rp', '.', ' ', ','], '', $value);
    }

}
