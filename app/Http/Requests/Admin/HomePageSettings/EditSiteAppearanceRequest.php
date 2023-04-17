<?php

namespace App\Http\Requests\Admin\HomePageSettings;

use App\Services\Enums\DECORATION_TYPES;
use App\Services\Enums\SITE_APPEARANCE;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Validator;

class EditSiteAppearanceRequest extends FormRequest
{
    private array $sections;
    protected function prepareForValidation()
    {
        $this->sections=[
            1=>SITE_APPEARANCE::HEADER->value,
            2=>SITE_APPEARANCE::MAIN->value,
            3=>SITE_APPEARANCE::FOOTER->value
        ];
    }

    public function rules(): array
    {
        $valueValidator=['required'];
        if ($this->get('type')===DECORATION_TYPES::COLOR->value){
            $valueValidator[]='string';
        }

        return [
            'section'=>['required',new Enum(SITE_APPEARANCE::class),
                function($attr,$val,$fail){
                      if ($val!==$this->sections[$this->route('id')]){
                          $fail('Every id has it`s own name');
                      }
                }],
            'type'=>['required',new Enum(DECORATION_TYPES::class)],
            'value'=>$valueValidator,
        ];
    }


}
