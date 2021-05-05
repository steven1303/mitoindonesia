<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransferReceipt extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_branch',
        'id_transfer',
        'receipt_transfer_no',
        'from_branch',
        'receipt_transfer_date',
        'receipt_transfer_status',
        'user_name',
        'user_id',
        'keterangan',
        'receipt_transfer_open',
        'receipt_transfer_print',
    ];

    public function branch()
    {
    	return $this->belongsTo('App\Models\Branch','id_branch');
    }

    public function from()
    {
    	return $this->belongsTo('App\Models\Branch','from_branch');
    }

    public function transfer()
    {
    	return $this->belongsTo('App\Models\TransferBranch','id_transfer');
    }

    public function transfer_receipt_detail()
    {
    	return $this->hasMany('App\Models\TransferReceiptDetail','id_receipt_transfer');
    }
}
