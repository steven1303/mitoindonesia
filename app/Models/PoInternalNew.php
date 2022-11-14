<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoInternalNew extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'po_no',
        'id_customer',
        'doc_no',
        'po_status',
        'ppn',
        'po_user_name',
        'po_user_id',
        'po_open',
        'po_print',
    ];

    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer','id_customer');
    }

    public function po_internal_detail()
    {
    	return $this->hasMany('App\Models\PoInternalDetailNew','id_po');
    }

    public function branch()
    {
    	return $this->belongsTo('App\Models\Branch','id_branch');
    }

    public function getPpnAttribute($ppn)
    {
        return $ppn - 0;
    }
}
