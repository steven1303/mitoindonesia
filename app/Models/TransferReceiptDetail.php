<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferReceiptDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'id_transfer_detail',
        'id_receipt_transfer',
        'id_stock_master_from',
        'id_stock_master',
        'qty',
        'price',
        'keterangan',
        'transfer_receipt_detail_status',
    ];

    public function stock_master()
    {
        return $this->belongsTo('App\Models\StockMaster','id_stock_master');
    }

    public function stock_master_from()
    {
        return $this->belongsTo('App\Models\StockMaster','id_stock_master_from');
    }

    public function transfer_receipt()
    {
        return $this->belongsTo('App\Models\TransferReceipt','id_receipt_transfer');
    }

    public function transfer_detail()
    {
        return $this->belongsTo('App\Models\TransferDetail','id_transfer_detail');
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
