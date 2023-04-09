<?php

namespace App\Http\Requests\Admin\Banner;

use Illuminate\Foundation\Http\FormRequest;

class EditBannerRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'title'=>'string|required',
            'description'=>'string|required',
            'link_text'=>'string|required',
            'image'=>'nullable|file|image',
            'value'=>'required|array|min:1',
            'value.*'=>'integer|required|exists:products,id',
        ];
    }
}
