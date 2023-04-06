<?php

namespace App\Http\Requests\Admin\Settings;

use Illuminate\Foundation\Http\FormRequest;

class UpsertRatesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function rules(): array
    {
        return [
            'data'=>['required','array','min:1',function($attr,$val,$fail){
                $currencies = collect($val)->pluck('currency');
                if ($currencies->count() !== $currencies->unique()->count()){
                    $fail('Currencies should be unique');
                }
            }],
            'data.*'=>['array',function ($attr,$val,$fail) {
                if (!$val['currency']){
                    $fail('Currency field is required');
                    return;
                }
                if (!$val['rate']){
                    $fail('Rate field is required');
                    return;
                }
                if (!preg_match('/^\d+(\.\d{1,2})?$/', $val['rate'])){
                    $fail('Rate files should be integer or decimal');
                }
            }]
        ];
    }
}
