<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoInternalDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'id_po',
        'id_stock_master',
        'qty',
        'price',
        'disc',
        'keterangan',
        'po_detail_status',
    ];

    public function stock_master()
    {
        return $this->belongsTo('App\Models\StockMaster','id_stock_master');
    }

    public function po_internal()
    {
        return $this->belongsTo('App\Models\PoInternal','id_po');
    }

    public function getTotalAttribute()
    {
        return ($this->qty * $this->price) - $this->disc;
    }

    public function getQtyAttribute($qty)
    {
        return $qty - 0;
    }

    public function getPriceAttribute($price)
    {
        return $price - 0;
    }

    public function getDiscAttribute($disc)
    {
        return $disc - 0;
    }
}
