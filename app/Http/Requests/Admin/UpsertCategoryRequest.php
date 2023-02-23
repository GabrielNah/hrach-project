<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpsertCategoryRequest extends FormRequest
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
            'name'=>['required','string',function($attribute,$value,$fail){
                if ($this->route('id')){
                    
                }
                if ($value && !Category::query()->pluck('id')->contains($value)){
                    $fail('Selected parent is invalid');
                }
            }],
            'parent'=>[function($attribute,$value,$fail){
                if ($value && !Category::query()->pluck('id')->contains($value)){
                    $fail('Selected parent is invalid');
                }
            }],
            'active'=>['nullable',Rule::in(['0','1'])],
        ];
    }
}
