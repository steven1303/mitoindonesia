<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecStockDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'id_rec',
        'id_po_detail',
        'id_mov_id',
        'id_stock_master',
        'order',
        'terima',
        'bo',
        'price',
        'disc',
        'keterangan',
        'rec_detail_status',
    ];

    public function stock_master()
    {
        return $this->belongsTo('App\Models\StockMaster','id_stock_master');
    }

    public function receipt()
    {
        return $this->belongsTo('App\Models\RecStock','id_rec');
    }

    public function po_detail()
    {
        return $this->belongsTo('App\Models\PoStockDetail','id_po_detail');
    }

    public function getOrderAttribute($order)
    {
        return $order - 0;
    }

    public function getTerimaAttribute($terima)
    {
        return $terima - 0;
    }

    public function getBoAttribute($bo)
    {
        return $bo - 0;
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
