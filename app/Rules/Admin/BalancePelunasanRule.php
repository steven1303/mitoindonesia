<?php

namespace App\Rules\Admin;

use Illuminate\Contracts\Validation\Rule;

class BalancePelunasanRule implements Rule
{

    protected $sisa;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($sisa)
    {
        $this->sisa = preg_replace('/\D/', '',$sisa);
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
        $balance = preg_replace('/\D/', '',$value);

        if($balance <= $this->sisa){
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
        return 'Bayar melebihi jumlah sisa';
    }
}
