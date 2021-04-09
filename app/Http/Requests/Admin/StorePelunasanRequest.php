<?php

namespace App\Http\Requests\Admin;

use App\Rules\Admin\BalancePelunasanRule;
use Illuminate\Foundation\Http\FormRequest;

class StorePelunasanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'balance' => ['required',new BalancePelunasanRule($this->input('sisa'))],
        ];
    }

    public function messages()
    {
        return [
            'balance.required' => 'Bayar is required',
        ];
    }
}
