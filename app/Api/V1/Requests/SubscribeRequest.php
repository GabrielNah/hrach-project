<?php

namespace App\Api\V1\Requests;

use App\Models\Subscriber;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubscribeRequest extends FormRequest
{
    public function messages(): array
    {
        return [
          'subscriber.required'=>'Please provide an email',
          'subscriber.email'=>'Please provide a valid email',
          'subscriber.unique'=>'This email is taken',
        ];
    }

    public function rules():array
    {
        return [
            'subscriber'=>'required|email|'.Rule::unique(Subscriber::TABLE,'subscriber'),
        ];
    }
}
