<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangeCredentialsRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'name'=>'nullable|string',
            'email'=>'nullable|string|email',
            'current_password'=>'nullable|string',
            'new_password'=>'nullable|string|confirmed',
            'new_password_confirmation'=>'nullable|string',
        ];
    }
}
