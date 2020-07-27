<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProduct extends FormRequest
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
            'name' => 'string',
            'code' => 'min:5',
            'warehouses' => 'array',
            'warehouses.*.id' => 'required|exists:warehouses',
            'warehouses.*.stock_level' => 'required|numeric|min:0'
        ];
    }
}
