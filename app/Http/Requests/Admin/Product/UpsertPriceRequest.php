<?php

namespace App\Http\Requests\Admin\Product;

use App\Models\Price;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpsertPriceRequest extends FormRequest
{
    protected $stopOnFirstFailure=true;

    public function rules(): array
    {
        return [
            'currency'=>Rule::in(Price::CURRENCIES),
            'min_count'=>'required|numeric|min:0',
            'max_count'=>['required','numeric','max:0',function($attr,$val,$fail){
                if ($val!==0 && $this->get('min_count') !== 0){
                    if ($val && $val < $this->get('min_count')){
                        $fail('min_count should be less then max_count');
                    }
                }
            }],
            'price'=>'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ];
    }

    public function withValidator(Validator $validator){
        $validator->after(function (Validator $validator){
            $product = $this->route('product');
            $min_count = $this->get('min_count');
            $max_count = $this->get('max_count');
            $editablePrice=compact('min_count','max_count');
            $prices = $product->prices()
                ->where('currency', $this->get('currency'))
                ->when($this->route('price'), function ($query) {
                    return $query->where('id', '!=', $this->route('price')->id);
                })
                ->get(['min_count', 'max_count']);
            $prices=collect($prices)->push($editablePrice)->sort('min_count');
            $prices->each(function ($price,$index)use ($validator,$prices){
                $prev = $prices[$index - 1] ?? null;
                $next = $prices[$index + 1] ?? null;

               if (isset($prev) && $prev['max_count'] >= $price['min_count']) {
                   $validator->errors()->add('min_count', 'The minimum count of the current price overlaps with the maximum count of the previous price.');
                    return;
               }
               if (isset($next) && $price['max_count'] && $price['max_count'] >= $next['min_count']) {
                   $validator->errors()->add('max_count', 'The maximum count of the current price overlaps with the minimum count of the next price.');
                    return;
               }
            });

        });
    }
}
