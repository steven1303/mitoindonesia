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
        'id_vendor',
        'qty',
        'keterangan',
        'id_po_stock',
        'po_stock_ket',
        'po_stock_price',
        'po_stock_disc',
        'po_stock_total_harga',
        'spbd_detail_status',
    ];
}
