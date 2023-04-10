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
        ];
    }
}
