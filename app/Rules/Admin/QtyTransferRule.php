<?php

namespace App\Rules\Admin;

use App\Models\StockMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class QtyTransferRule implements Rule
{
    protected $stock_master;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($stock_master)
    {
        $this->stock_master = $stock_master;
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
        $stock = StockMaster::where([
            ['id','=', $this->stock_master],
            ['id_branch','=', Auth::user()->id_branch]
        ])->first()->stock_movement->sum('soh_qty');

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
        return 'Qty SOH is not enough';
    }
}
