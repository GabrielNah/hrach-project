<?php

namespace App\Http\Requests\Admin\Settings;

use App\Models\Admin;
use App\Models\Color;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreColorRequest extends FormRequest
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
                'name'=>'required|string|'.Rule::unique('colors','name')->where('type',Color::TYPE_GLOBAL),
                'value'=>'required|string|unique:colors,value'
            ];
    }
}
