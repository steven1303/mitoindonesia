<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoNonStockDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'id_po',
        'product',
        'id_spb_detail',
        'price',
        'disc',
        'keterangan',
        'po_detail_status',
    ];

    public function spb_detail()
    {
    	return $this->hasOne('App\Models\SpbDetail','id','id_spb_detail');
    }

    public function po_non_stock()
    {
        return $this->belongsTo('App\Models\PoNonStock','id_po');
    }

    public function getPriceAttribute($price)
    {
        return $price - 0;
    }

    public function getDiscAttribute($disc)
    {
        return $disc - 0;
    }
    public function getTotalAttribute()
    {
        return ($this->spb_detail->qty * $this->price) - $this->disc;
    }
}
