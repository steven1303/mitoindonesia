<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelunasan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'pelunasan_no',
        'id_inv',
        'balance',
        'payment_method',
        'pelunasan_date',
        'notes',
        'keterangan',
        'user_name',
        'user_id',
        'status',
    ];

    public function invoice()
    {
    	return $this->belongsTo('App\Models\Invoice','id_inv');
    }

    public function branch()
    {
    	return $this->belongsTo('App\Models\Branch','id_branch');
    }
}
