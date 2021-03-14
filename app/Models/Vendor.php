<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'id_branch',
        'address1',
        'address2',
        'city',
        'phone',
        'pic',
        'telp',
        'npwp',
        'ppn',
        'status_ppn',
    ];

    public function po_stock()
    {
    	return $this->hasMany('App\Models\PoStock','id_vendor');
    }
}
