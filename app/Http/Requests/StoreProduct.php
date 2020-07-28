<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProduct extends FormRequest
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
            'name' => 'required|string|max:191',
            'code' => 'required|min:5|max:191',
            'warehouses' => 'required|array',
            'warehouses.*.id' => 'required|exists:warehouses',
            'warehouses.*.stock_level' => 'required|numeric|min:1'
        ];
    }
}
