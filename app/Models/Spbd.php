<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spbd extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'spbd_no',
        'spbd_date',
        'spbd_status',
        'spbd_user_name',
        'spbd_user_id',
    ];
}
