<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'category'=>'required|integer|exists:categories,id',
            'name'=>'string|required|unique:products,name',
            'title'=>'required|string',
            'description'=>'required|string',
            'is_active'=>[Rule::in(['on','off'])],
            'rating'=>'required|numeric|min:1|max:5',
            'price_for_one'=>'required|array',
            'currencies_for_one'=>'required|array',
            'general_file'=>'required|file',
            'files'=>'array|present',
            'colors'=>'required|array',
            'sizes'=>'required|array',
            'metaDataName'=>'nullable|array',
            'metaDataValue'=>'nullable|array',
            'metaDataName.*'=>'string',
            'metaDataValue.*'=>'string',

        ];
    }
}
