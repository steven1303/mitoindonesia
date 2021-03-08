<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_stock_master',
        'id_branch',
        'move_date',
        // 'bin',
        'type',
        'doc_no',
        'order_qty',
        'sell_qty',
        'in_qty',
        'out_qty',
        'harga_modal',
        'harga_jual',
        'user',
        'ket',
    ];

    public function stock_master()
    {
    	return $this->belongsTo('App\Models\StockMaster','id_stock_master');
    }

    public function branch()
    {
    	return $this->belongsTo('App\Models\Branch','id_branch');
    }

    public function getSohQtyAttribute()
    {
        return $this->in_qty - $this->out_qty;
    }

    public function getOrderQtyAttribute($order_qty)
    {
        return $order_qty - 0;
    }

    public function getSellQtyAttribute($sell_qty)
    {
        return $sell_qty - 0;
    }

    public function getInQtyAttribute($in_qty)
    {
        return $in_qty - 0;
    }

    public function getOutQtyAttribute($out_qty)
    {
        return $out_qty - 0;
    }

    public function getHargaModalAttribute($harga_modal)
    {
        return $harga_modal - 0;
    }

    public function getHargaJualAttribute($harga_jual)
    {
        return $harga_jual - 0;
    }
}
