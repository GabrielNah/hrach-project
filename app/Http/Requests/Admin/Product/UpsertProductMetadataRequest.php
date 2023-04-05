<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Category;
use App\Models\Color;
use App\Models\Price;
use App\Models\Size;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpsertProductMetadataRequest extends FormRequest
{

    public function rules():array
    {
        return [
            'keys'=>['present','array',function($attr,$val,$fail){
                if (!is_array($val)){
                    return;
                }
                if (collect($val)->count() !== collect($val)->unique()->count()){
                    $fail('Keys of metadata should be unique');
                }
            }],
            'values'=>['present','array',function($attr,$val,$fail){
                if (count($val)!== count($this->get('keys'))){
                    $fail('Every present key should be having it`s own value');
                }
            }]
        ];
    }

    public function validated($key = null, $default = null): array
    {

        $keys = array_values($this->get('keys'));
        $values = array_values($this->get('values'));
        $metadata = [];
        if (count($keys)){
            foreach ($keys as $index =>$key){
                $metadata[$key] = $values[$index];
            }
        }

        return $metadata;
    }

}
