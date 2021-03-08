<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoStockDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'id_po',
        'id_spbd_detail',
        'id_stock_master',
        'rec_qty',
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

    public function po_stock()
    {
        return $this->belongsTo('App\Models\PoStock','id_po');
    }

    public function spbd_detail()
    {
        return $this->belongsTo('App\Models\SpbdDetail','id_spbd_detail');
    }

    public function rec_detail()
    {
    	return $this->hasMany('App\Models\RecStockDetail','id_po_detail');
    }

    public function getQtyAttribute($qty)
    {
        return $qty - 0;
    }

    public function getTotalAttribute($qty)
    {
        return $this->qty * $this->price;
    }

    public function getRecQtyAttribute($rec_qty)
    {
        return $rec_qty - 0;
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
