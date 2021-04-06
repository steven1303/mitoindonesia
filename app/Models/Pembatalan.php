<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembatalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'pembatalan_no',
        'pembatalan_type',
        'doc_no',
        'user_name',
        'keterangan',
        'user_id',
        'po_open',
        'po_print',
        'status',
    ];

    public function branch()
    {
    	return $this->belongsTo('App\Models\Branch','id_branch');
    }

    public function po_non_stock()
    {
    	return $this->belongsTo('App\Models\PoNonStock','doc_no','po_no');
    }

    public function po_stock()
    {
    	return $this->belongsTo('App\Models\PoStock','doc_no','po_no');
    }

    public function invoice()
    {
    	return $this->belongsTo('App\Models\Invoice','doc_no','inv_no');
    }

}
