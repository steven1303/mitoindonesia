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
        'invoice_id',
        'sppb_po_cust',
        'po_cust_status',
        'sppb_status',
        'sppb_user_name',
        'sppb_user_id',
        'sppb_open',
        'sppb_print',
    ];

    public function scopeDetails($query)
    {
        $query->addSelect(['invoice_status' => Invoice::whereColumn('id', 'sppbs.invoice_id')
            ->selectRaw('inv_status as invoice_status')
        ]);
    }

    public function customer()
    {
    	return $this->belongsTo('App\Models\Customer','id_customer');
    }

    public function sppb_detail()
    {
    	return $this->hasMany('App\Models\SppbDetail','sppb_id');
    }

    public function invoice()
    {
    	return $this->belongsTo('App\Models\Invoice','invoice_id');
    }

    public function branch()
    {
    	return $this->belongsTo('App\Models\Branch','id_branch');
    }
}
