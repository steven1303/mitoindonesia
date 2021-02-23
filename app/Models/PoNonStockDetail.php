<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoNonStockDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'id_po',
        'id_spb_detail',
        'price',
        'disc',
        'keterangan',
        'po_detail_status',
    ];

    public function spb_detail()
    {
    	return $this->hasOne('App\Models\SpbDetail','id','id_spb_detail');
    }

    public function po_non_stock()
    {
        return $this->belongsTo('App\Models\PoNonStock','id_po');
    }
}
