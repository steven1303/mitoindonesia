<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockMaster extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_no',
        'name','bin',
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

}
