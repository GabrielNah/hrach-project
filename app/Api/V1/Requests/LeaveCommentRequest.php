<?php

namespace App\Api\V1\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeaveCommentRequest extends FormRequest
{
    public function rules():array
    {
        return [
            'comment'=>'required|string',
            'username'=>'required|string',
            'rating'=>'integer|min:1',
        ];
    }
}
