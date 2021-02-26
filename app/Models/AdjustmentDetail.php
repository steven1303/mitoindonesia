<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjustmentDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'adj_id',
        'id_stock_master',
        'in_qty',
        'out_qty',
        'harga_modal',
        'harga_jual',
        'keterangan',
    ];

    public function stock_master()
    {
        return $this->belongsTo('App\Models\StockMaster','id_stock_master');
    }

    public function adj()
    {
        return $this->belongsTo('App\Models\Adjustment','adj_id');
    }
}
