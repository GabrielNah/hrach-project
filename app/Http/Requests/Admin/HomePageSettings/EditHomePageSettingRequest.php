<?php

namespace App\Http\Requests\Admin\HomePageSettings;

use App\Models\HomePageSettings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class EditHomePageSettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'products'=>'array|required|min:1',
            'products.*'=>'integer|required|exists:products,id',
            'section_name'=>'string|required|'.Rule::unique(HomePageSettings::TABLE,'section_name')->ignore($this->route('home')),
            'showable_count'=>'integer|required',
            'main'=>'required|boolean',
        ];
    }

    protected function withValidator(Validator $validator):void
    {
        $validator->after(function (Validator $validator){
            if ($this->get('main')){
                $main_id = HomePageSettings::query()->where('main',true)->value('id');
                $id=(integer)$this->route('home');
                if ($id && $main_id!==$id){
                    $validator->errors()->add('Setting','Main section can be only one');
                }
            }
        });
    }

}
