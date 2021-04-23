<?php

namespace App\Rules\Admin;

use App\Models\PoInternal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;

class PoInternalRule implements Rule
{
    protected $customer;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($customer)
    {
        $this->customer = $customer;
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
        $po_internal_check = PoInternal::where([
            ['po_no','=', $value],
            ['id_branch','=', Auth::user()->id_branch],
            ['id_customer','=', $this->customer],
            ['po_status','=', '3' ]
        ])->count();
        if($po_internal_check > 0){
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
        return 'PO Internal is not found for this customer';
    }
}
