<?php

namespace App\Http\Requests\Admin\Slider;

use Illuminate\Foundation\Http\FormRequest;

class EditSliderRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'image'=>'nullable|file|image',
            'title'=>'required|string',
            'link_text'=>'required|string',
            'value'=>'required|array|min:1',
            'value.*'=>'integer|exists:products,id'
        ];
    }
}
