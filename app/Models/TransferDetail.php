<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'id_transfer',
        'id_stock_master',
        'qty',
        'rec_qty',
        'price',
        'keterangan',
        'transfer_detail_status',
    ];

    public function stock_master()
    {
        return $this->belongsTo('App\Models\StockMaster','id_stock_master');
    }

    public function transfer()
    {
        return $this->belongsTo('App\Models\TransferBranch','id_transfer');
    }

    public function getQtyAttribute($qty)
    {
        return $qty - 0;
    }

    public function getTotalAttribute()
    {
        return ($this->qty * $this->price);
    }

    public function getPriceAttribute($price)
    {
        return $price - 0;
    }
}
