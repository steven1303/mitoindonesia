<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferBranch extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'transfer_no',
        'to_branch',
        'transfer_date',
        'transfer_status',
        'user_name',
        'user_id',
        'transfer_open',
        'transfer_print',
    ];

    public function branch()
    {
    	return $this->belongsTo('App\Models\Branch','id_branch');
    }

    public function tujuan()
    {
    	return $this->belongsTo('App\Models\Branch','to_branch');
    }

    public function transfer_detail()
    {
    	return $this->hasMany('App\Models\TransferDetail','id_transfer');
    }

}
