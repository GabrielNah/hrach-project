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
            'min_count'=>'required|array|min:1',
            'min_count.*'=>'numeric|min:1',
            'max_count'=>['required','array','min:1'],
            'price'=>['required','array','min:1'],
            'max_count.*'=>['nullable','numeric','min:1'],
            'price.*'=>'required|numeric|regex:/^\d+(\.\d{1,2})?$/'
        ];
    }

    private function getModifiedData():array
    {
        $min_count=$this->get('min_count');
        $max_count=$this->get('max_count');
        $prices=$this->get('price');
        $validatedPrices = [];
        foreach ($prices as $index => $price){
            $result=[];
            $result['price']=$price;
            $result['min_count']=$min_count[$index];
            $result['max_count']=$max_count[$index];
            $validatedPrices[]=$result;
        }
        return  $validatedPrices;
    }

    private function pricesAreOverwlaped():bool
    {
        $prices = $this->getModifiedData();
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
            if ($this->pricesAreOverwlaped()){
                $validator->errors()->add('Prices','Prices should not be overwlaped');
            }
      });
    }

    public function validated($key = null, $default = null)
    {
        $validated=[];
        $validated['prices']=$this->getModifiedData();
        return data_get($validated, $key, $validated);
    }


}
