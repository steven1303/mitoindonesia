<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembatalan extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'pembatalan_no',
        'pembatalan_type',
        'doc_no',
        'user_name',
        'keterangan',
        'user_id',
        'po_open',
        'po_print',
        'status',
    ];

}
