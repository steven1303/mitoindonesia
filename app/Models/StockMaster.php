<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_no',
        'name',
        'bin',
        'harga_modal',
        'harga_jual',
        'id_branch',
        'satuan',
        'min_soh',
        'max_soh'
    ];

    public function stock_movement()
    {
        return $this->hasMany('App\Models\StockMovement','id_stock_master');
    }

    public function branch()
    {
    	return $this->belongsTo('App\Models\Branch','id_branch');
    }

    public function getHargaModalAttribute($harga_modal)
    {
        return $harga_modal - 0;
    }

    public function getHargaJualAttribute($harga_jual)
    {
        return $harga_jual - 0;
    }

    public function getMinSohAttribute($min_soh)
    {
        return $min_soh - 0;
    }

    public function getMaxSohAttribute($max_soh)
    {
        return $max_soh - 0;
    }

}
