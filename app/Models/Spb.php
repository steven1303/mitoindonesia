<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spb extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'spb_no',
        'id_vendor',
        'spb_date',
        'spb_status',
        'spb_user_name',
        'spb_user_id',
        'spb_open',
        'spb_print'
    ];

    public function vendor()
    {
    	return $this->belongsTo('App\Models\Vendor','id_vendor');
    }

    public function spb_detail()
    {
    	return $this->hasMany('App\Models\SpbDetail','spb_id');
    }

    public function branch()
    {
    	return $this->belongsTo('App\Models\Branch','id_branch');
    }
}
