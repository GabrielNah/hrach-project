<?php

namespace App\Http\Requests\Admin\Slider;

use Illuminate\Foundation\Http\FormRequest;

class StoreSliderRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'image'=>'file|image|required',
            'title'=>'required|string',
            'link_text'=>'required|string',
            'value'=>'required|array|min:1',
            'value.*'=>'integer|exists:products,id'
        ];
    }
}
