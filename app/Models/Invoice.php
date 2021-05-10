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
        'inv_open',
        'inv_print',
    ];

    public function branch()
    {
    	return $this->belongsTo('App\Models\Branch','id_branch');
    }

    public function sppb()
    {
    	return $this->belongsTo('App\Models\Sppb','id_sppb');
    }

    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer','id_customer');
    }

    public function inv_detail()
    {
    	return $this->hasMany('App\Models\InvoiceDetail','id_inv');
    }

    public function pelunasan()
    {
    	return $this->hasMany('App\Models\Pelunasan','id_inv');
    }    

    public function getTotalPpnAttribute()
    {
        return $this->inv_detail->sum('total_ppn');
    }

    public function getPpnAttribute($ppn)
    {
        return $ppn - 0;
    }
}
