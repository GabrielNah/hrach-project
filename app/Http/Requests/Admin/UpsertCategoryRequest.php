<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin;
use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
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
                if ($this->route('category')){
                    $names=$this->getNamesOfOtherCategories($this->route('category')->id);
                    if ($names->contains($value)){
                        $fail('This name is already taken');
                    }
                    return;
                }
                $names=$this->getNamesOfCategories();
                if ($names->contains($value)){
                    $fail('This name is already taken');
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


    private function getNamesOfOtherCategories(int $id):Collection
    {
        return Category::query()->whereNot('id',$id)->pluck('name');
    }

    private function getNamesOfCategories():Collection
    {
        return Category::query()->pluck('name');
    }
}
