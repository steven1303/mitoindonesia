<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreDetailReceiptRequest extends FormRequest
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
            'terima' => ['required', 'lte:'.$this->input('qty')],
        ];
    }

    public function messages()
    {
        return [
            'terima.required' => 'Terima is required',
            'terima.lte' => 'Over than Ordering',
        ];
    }
}
