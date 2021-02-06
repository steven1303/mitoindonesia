<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PoStock extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'po_no',
        'id_spbd',
        'id_vendor',
        'po_ord_date',
        'po_status',
        'ppn',
        'spbd_user_name',
        'spbd_user_id',
    ];

    public function spbd()
    {
    	return $this->belongsTo('App\Models\Spbd','id_spbd');
    }

}
