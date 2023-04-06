<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class EditProductMainInfoRequest extends FormRequest
{
    protected $stopOnFirstFailure=true;

    public function rules(): array
    {
        return [
            'name'=>'required|string',
            'title'=>'required|string',
            'rating'=>'required|numeric|min:1|max:5',
            'description'=>'required|string',
            'active'=>['required','boolean'],
            'category'=>['required','integer','exists:categories,id'],
        ];
    }




}
