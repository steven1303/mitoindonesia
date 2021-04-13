<?php

namespace App\Http\Requests\Admin;

use App\Rules\Admin\QtyTransferRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransferDetailRequest extends FormRequest
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
            'qty' => ['required', new QtyTransferRule($this->input('stock_master'))],
            'stock_master' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'qty.required' => 'QTY is required',
            'stock_master.required' => 'Stock Master is required',
        ];
    }
}
