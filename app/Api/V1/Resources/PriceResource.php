<?php

namespace App\Api\V1\Resources;

use App\Models\CurrencyRate;
use App\Models\Price;
use App\Services\PriceRateConvertor\PriceRateConvertor;
use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
{
    public function toArray($request):array
    {
        return  [
            'id'=>$this->resource->id,
            'max_count'=>$this->resource->max_count,
            'min_count'=>$this->resource->min_count,
            'currency'=>Price::USD,
            'discount'=>$this->resource->discount,
            'negotiable'=> (bool)$this->resource->negotiable,
            'price'=>$this->formatNumber($this->resource->price),
        ];
    }

    private function formatNumber($value) {
        $floatValue = is_string($value) ? (float)$value : $value;

        if (floor($floatValue) == $floatValue) {
            return intval($floatValue);
        }

        $formattedValue = number_format($floatValue, 2, '.', '');
        if (substr($formattedValue, -1) != '0') {
            return $formattedValue;
        }

        return intval($floatValue);
    }


    public static function collection($resource)
    {
        $collection = collect(parent::collection($resource));
        $currencyRates = CurrencyRate::query()->get()->collect();
        $otherCurrencies=[];
        foreach ($currencyRates as $currencyRate){
            $collection->each(function ($price) use ($currencyRate,&$otherCurrencies){
                $otherCurrencyPrice=[];
                $otherCurrencyPrice['id'] = $price['id'];
                $otherCurrencyPrice['min_count'] = $price['min_count'];
                $otherCurrencyPrice['max_count'] = $price['max_count'];
                $otherCurrencyPrice['discount'] = $price['discount'];
                $otherCurrencyPrice['negotiable'] = $price['negotiable'];
                $otherCurrencyPrice['currency']=$currencyRate->currency;
                $otherCurrencyPrice['price']=(new PriceRateConvertor())->convertToCurrency($price['price'],$currencyRate->currency);
                $otherCurrencies[]=$otherCurrencyPrice;
            });
        }

        return $collection->merge(collect($otherCurrencies))->sortBy('min_count')->groupBy(function ($key)use ($currencyRates){
           $currences=$currencyRates->pluck('currency')->push(Price::USD)->toArray();
           if(in_array($key['currency'],$currences)){
                return $key['currency'];
            }
           return Price::USD;
        });
    }
}
