<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpbDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'spb_id',
        'keterangan',
        'qty',
        'satuan',
        'spb_detail_status',
    ];

    public function spb()
    {
        return $this->belongsTo('App\Models\Spb','spb_id');
    }
}
