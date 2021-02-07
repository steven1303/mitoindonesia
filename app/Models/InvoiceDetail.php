<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'id_sppb_detail',
        'id_inv',
        'id_stock_master',
        'qty',
        'price',
        'disc',
        'subtotal',
        'total_befppn',
        'total_ppn',
        'keterangan',
        'inv_detail_status',
    ];

    public function stock_master()
    {
        return $this->belongsTo('App\Models\StockMaster','id_stock_master');
    }

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice','id_inv');
    }

    public function sppb_detail()
    {
        return $this->belongsTo('App\Models\SppbDetail','id_sppb_detail');
    }
}
