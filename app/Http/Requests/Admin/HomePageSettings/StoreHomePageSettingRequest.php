<?php

namespace App\Http\Requests\Admin\HomePageSettings;

use App\Models\HomePageSettings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreHomePageSettingRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'products'=>'array|required|min:1',
            'products.*'=>'integer|required|exists:products,id',
            'section_name'=>'string|required|unique:'.HomePageSettings::TABLE.',section_name',
            'showable_count'=>'integer|required',
            'main'=>'required|boolean',
        ];
    }

    protected function withValidator(Validator $validator):void
    {
        $validator->after(function (Validator $validator){
            if (HomePageSettings::query()->count() === 2){
                $validator->errors()->add('Settings','Home page setting can be only 2');
                return;
            }
            if ($this->get('main') && $this->mainSectionExists()){
                $validator->errors()->add('Settings','Main section can be only 1');
            }
        });
    }

    private function mainSectionExists():bool
    {
        return HomePageSettings::query()->where('main',true)->exists();
    }
}
