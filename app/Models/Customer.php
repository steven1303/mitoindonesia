<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'id_branch',
        'address1',
        'address2',
        'email',
        'city',
        'pic',
        'telp',
        'phone',
        'npwp',
        'ktp',
        'bod',
        'ppn',
        'status_ppn'
    ];

    public function invoice()
    {
    	return $this->hasMany('App\Models\Invoice','id_customer');
    }
}
