<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sppb extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'sppb_no',
        'sppb_date',
        'id_customer',
        'sppb_po_cust',
        'sppb_status',
        'sppb_user_name',
        'sppb_user_id',
    ];

    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer','id_customer');
    }
}
