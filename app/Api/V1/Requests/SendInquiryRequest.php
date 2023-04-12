<?php

namespace App\Api\V1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendInquiryRequest extends FormRequest
{
    public function rules():array
    {
        return [
            'email'=>'required|email',
            'username'=>'required|string',
            'count'=>'required|numeric|min:1',
            'product_id'=>'integer|exists:products,id',
            'inquiry'=>'required|string',
        ];
    }
}
