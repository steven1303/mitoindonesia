<?php

namespace App\Rules\Admin;

use App\Models\TransferDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class QtyTransferReceiptRule implements Rule
{

    protected $transfer;
    protected $status;
    protected $id_transfer_receipt_detail;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($transfer, $status, $id = 0)
    {
        $this->transfer = $transfer;
        $this->status = $status;
        $this->id_transfer_receipt_detail = $id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($this->status == 2){
            $data = TransferDetail::where([
                ['id','=', $this->transfer]
            ])->first();

            $stock = $data->qty - $data->rec_qty + $data->rec_detail->where('id','=',  $this->id_transfer_receipt_detail)->first()->qty;
            if($stock >= $value){
                return true;
            }
            return false;
        }
        $data = TransferDetail::where([
            ['id','=', $this->transfer]
        ])->first();

        // dd($this->status);
        $stock = $data->qty - $data->rec_qty;
        if($stock >= $value){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Terima Qty Transfer is over.';
    }
}
