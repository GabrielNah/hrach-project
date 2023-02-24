<?php

namespace App\Http\Requests\Admin\Settings;

use App\Models\Admin;
use Illuminate\Foundation\Http\FormRequest;

class EditColorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && auth()->user() instanceof Admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'=>'required|string|unique:colors,name,'.$this->route('id'),
            'value'=>'required|string|unique:colors,value,'.$this->route('id'),
        ];
    }
}
