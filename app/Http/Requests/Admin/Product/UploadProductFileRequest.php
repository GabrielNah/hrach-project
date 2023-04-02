<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;


class UploadProductFileRequest extends FormRequest
{
    public function rules():array
    {
        info(json_encode(request()->all()));
        return [
            'uploaded_file'=>'required|file'
        ];
    }

}
