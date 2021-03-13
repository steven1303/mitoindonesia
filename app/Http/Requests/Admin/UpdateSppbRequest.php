<?php

namespace App\Http\Requests\Admin;

use Illuminate\Support\Arr;
use App\Rules\Admin\PoInternalRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSppbRequest extends FormRequest
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
        $contains = Arr::has($this->input(), 'status_po_internal');
        if($contains){
            return [
                'customer' => ['required'],
                'sppb_po_cust' => ['required', new PoInternalRule($this->input('customer'))],
            ];
        }
        return [
            'customer' => ['required'],
            'sppb_po_cust' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'customer.required' => 'Customer is required',
            'sppb_po_cust.required' => 'PO Customer is required',
        ];
    }
}
