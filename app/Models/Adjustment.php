<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'adj_no',
        'status',
        'user_name',
        'user_id',
    ];

    public function adj_detail()
    {
    	return $this->hasMany('App\Models\AdjustmentDetail','adj_id');
    }
}
