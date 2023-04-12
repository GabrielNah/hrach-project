<?php

namespace App\Http\Requests\Admin\Product\Price;

use App\Models\Price;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StorePriceRequest extends FormRequest
{
    protected $stopOnFirstFailure=true;

    private Collection $prices;
    protected function prepareForValidation()
    {
        $product=$this->route('product');
        if ($product){
            $this->prices = $product->prices()->get()->collect();
        }
    }

    public function rules(): array
    {
        return [
            'price'=>'required|array',
            'price.min_count'=>'numeric|min:1',
            'price.discount'=>['required','numeric','min:0','max:100'],
            'price.max_count'=>['nullable','numeric','min:1'],
            'price.price'=>'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
            'price.negotiable'=>'boolean'
        ];
    }

    private function thereIsOnlyOnePriceForOne():bool
    {

        if ((int)$this->get('price')['min_count'] === 1
            &&
            (int) $this->get('price')['max_count'] === 1){

            return !$this->prices->contains(function ($pr){
                return  ($pr['min_count'] === 1 && $pr['max_count'] === 1);
            });
        }
        return true;
    }

    private function pricesAreOverwlaped():bool
    {

        $prices = $this->prices->push($this->get('price'))
            ->sortBy(fn($pr)=>$pr['min_count'])->values()->all();
        foreach ($prices as $index => $price){
            $prev = $prices[$index - 1] ?? null;
            $next = $prices[$index + 1] ?? null;

            if (isset($prev) && $prev['max_count'] >= $price['min_count']) {
                return true;

            }
            if (isset($next) && $price['max_count'] && $price['max_count'] >= $next['min_count']) {
                return true;
            }
        }

        return false;
    }

    protected function withValidator(Validator $validator):void
    {
      $validator->after(function (Validator $validator){

          if (!$this->thereIsOnlyOnePriceForOne()){
              $validator->errors()->add('Prices','Price for one should be only 1');
              return;
          }
          if ($this->pricesAreOverwlaped()){
              $validator->errors()->add('Prices','Prices should not be overwlaped!');
              return;
          }
      });
    }


}
