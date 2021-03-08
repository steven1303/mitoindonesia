<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppbDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'sppb_id',
        'id_stock_master',
        'inv_qty',
        'qty',
        'price',
        'keterangan',
        'sppb_detail_status',
    ];

    public function stock_master()
    {
        return $this->belongsTo('App\Models\StockMaster','id_stock_master');
    }

    public function sppb()
    {
        return $this->belongsTo('App\Models\Sppb','sppb_id');
    }

    public function getQtyAttribute($qty)
    {
        return $qty - 0;
    }

    public function getPriceAttribute($price)
    {
        return $price - 0;
    }

    public function getInvQtyAttribute($inv_qty)
    {
        return $inv_qty - 0;
    }
}
