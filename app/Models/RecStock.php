<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'rec_no',
        'id_vendor',
        'id_po_stock',
        'rec_inv_ven',
        'rec_date',
        'ppn',
        'status',
        'user_id',
        'user_name',
        'rec_open',
        'rec_print',
    ];

    public function po_stock()
    {
    	return $this->belongsTo('App\Models\PoStock','id_po_stock');
    }

    public function vendor()
    {
    	return $this->belongsTo('App\Models\Vendor','id_vendor');
    }

    public function receipt_detail()
    {
    	return $this->hasMany('App\Models\RecStockDetail','id_rec');
    }

    public function getPpnAttribute($ppn)
    {
        return $ppn - 0;
    }
}
