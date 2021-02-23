<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoNonStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'po_no',
        'id_spb',
        'id_vendor',
        'po_status',
        'user_name',
        'user_id',
    ];

    public function spb()
    {
    	return $this->belongsTo('App\Models\Spb','id_spb');
    }

    public function vendor()
    {
    	return $this->belongsTo('App\Models\Vendor','id_vendor');
    }

    public function po_non_stock_detail()
    {
    	return $this->hasMany('App\Models\PoNonStockDetail','id_po');
    }
}
