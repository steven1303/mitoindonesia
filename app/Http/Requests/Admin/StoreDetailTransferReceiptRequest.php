<?php

namespace App\Http\Requests\Admin;

use App\Rules\Admin\QtyTransferReceiptRule;
use App\Rules\Admin\NoStockMasterRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreDetailTransferReceiptRequest extends FormRequest
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
            'terima' => ['required', new QtyTransferReceiptRule($this->input('id_transfer_detail'), 1)],
            'stock_master' => ['required', new NoStockMasterRule($this->input('stock_master_from')) ],
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
