<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SppbNew extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'sppb_no',
        'id_po_internal',
        'sppb_date',
        'sppb_status',
        'sppb_user_name',
        'sppb_user_id',
        'sppb_open',
        'sppb_print',
    ];

    public function scopePoInternal($query)
    {
        $query->addSelect(['po_no' => PoInternalNew::whereColumn('id','sppb_news.id_po_internal' )
            ->selectRaw('po_no as po_no')
        ]);
    }

    public function po_internal()
    {
    	return $this->belongsTo('App\Models\PoInternalNew','id_po_internal');
    }

    public function sppb_detail()
    {
    	return $this->hasMany('App\Models\SppbDetail','sppb_id');
    }

    public function branch()
    {
    	return $this->belongsTo('App\Models\Branch','id_branch');
    }
}
