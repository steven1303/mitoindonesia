<?php

namespace App\Rules\Admin;

use App\Models\StockMaster;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class NoStockMasterRule implements Rule
{

    protected $stock_no;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($stock_no)
    {
        $this->stock_no = $stock_no;
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
            ['id','=', $value],
            ['id_branch','=', Auth::user()->id_branch]
        ])->first()->stock_no;
        // dd($stock);
        if($stock == $this->stock_no){
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
        return 'Stock No. Difference';
    }
}
