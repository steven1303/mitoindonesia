<?php

namespace App\Http\Requests\Admin;

use App\Rules\Admin\QtyTransferReceiptRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDetailTransferReceiptRequest extends FormRequest
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
            'terima' => ['required', new QtyTransferReceiptRule($this->input('id_transfer_detail'), 2, $this->input('id'))],
            'stock_master' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'terima.required' => 'Terima is required',
            'stock_master.required' => 'Stock Master Code not detected.',
        ];
    }
}
