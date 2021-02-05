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
        'bin',
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
}
