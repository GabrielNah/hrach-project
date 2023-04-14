<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeCredentialsRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name'=>'string',
            'email'=>'string|email',
            'current_password'=>'string',
            'new_password'=>'string|confirmed',
            'new_password_confirmation'=>'string',
        ];
    }
}
