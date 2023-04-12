<?php

namespace App\Api\V1\Requests;

use App\Services\Enums\SEARCH_TYPES;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class SearchProductsRequest extends FormRequest
{
    public function rules():array
    {
        return [
            'type'=>['required','string',new Enum(SEARCH_TYPES::class)],
            'ids'=>['array','min:1',
                Rule::requiredIf($this->get('type') === SEARCH_TYPES::IDS->value)
            ],
            'ids.*'=>['integer','exists:products,id'],
            'category'=>['string',
                Rule::requiredIf($this->get('type') === SEARCH_TYPES::CATEGORY->value),
            ],
            'value'=>['string',
                Rule::requiredIf($this->get('type') === SEARCH_TYPES::DEFAULT->value)
            ],
            'filter'=>[Rule::requiredIf($this->get('type') === SEARCH_TYPES::FILTER->value),
            'array'],
            'filter.categories'=>'array',
            'filter.colors'=>'array',
            'filter.tags'=>'array',
            'filter.rating'=>'array',
            'filter.sizes'=>'array',
            'filter.categories.*'=>['integer','exists:categories,id'],
            'filter.colors.*'=>['integer','exists:colors,id'],
            'filter.tags.*'=>['integer','exists:tags,id'],
            'filter.rating.*'=>['integer','min:1','max:5'],
            'filter.sizes.*'=>['integer','exists:sizes,id'],
            'filter.price_min'=>['integer','min:0'],
            'filter.price_max'=>['integer','max:10001'],

        ];
    }
}
