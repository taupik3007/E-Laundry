<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory, SoftDeletes ;
    protected $table = 'discounts';
    protected $primaryKey = 'dsc_id';
    protected $guarded = [];

    const CREATED_AT = 'dsc_created_at';
    const UPDATED_AT = 'dsc_updated_at';
    const DELETED_AT = 'dsc_deleted_at';

    protected $appends = ['dsc_total_label'];

    public function getDscTotalLabelAttribute()
    {
        if ($this->dsc_type === 'percent') {
            return $this->dsc_total . '%';
        }

        return 'Rp ' . number_format($this->dsc_total, 0, ',', '.');
    }
    public function getDscStatusBadgeAttribute()
{
    return $this->dsc_status == 1
        ? '<span class="badge bg-success">Aktif</span>'
        : '<span class="badge bg-secondary">Nonaktif</span>';
}

}
