<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'inv_no',
        'date',
        'id_customer',
        'inv_kirimke',
        'inv_alamatkirim',
        'mata_uang',
        'top_date',
        'id_sppb',
        'po_cust',
        'befppn',
        'ppn',
        'total',
        'user_name',
        'user_id',
        'inv_status',
    ];

    public function sppb()
    {
    	return $this->belongsTo('App\Models\Sppb','id_sppb');
    }
}
