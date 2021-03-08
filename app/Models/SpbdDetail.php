<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpbdDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'spbd_id',
        'id_stock_master',
        'qty',
        'po_qty',
        'keterangan',
        'spbd_detail_status',
    ];

    public function stock_master()
    {
        return $this->belongsTo('App\Models\StockMaster','id_stock_master');
    }

    public function spbd()
    {
        return $this->belongsTo('App\Models\Spbd','spbd_id');
    }

    public function getQtyAttribute($qty)
    {
        return $qty - 0;
    }

    public function getPoQtyAttribute($po_qty)
    {
        return $po_qty - 0;
    }
}
