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

class StoreProductRequest extends FormRequest
{

    private Collection $colors;
    private Collection $sizes;

    protected function prepareForValidation()
    {
        $this->colors=Color::query()->pluck('id');
        $this->sizes=Size::query()->pluck('id');
    }

    public function rules(): array
    {

        return [
            'category'=>'required|integer|exists:categories,id',
            'name'=>'string|required|unique:products,name',
            'title'=>'required|string',
            'description'=>'required|string',
            'is_active'=>[Rule::in(['on','off'])],
            'rating'=>'required|numeric|min:1|max:5',
            'price_for_one'=>'required|array',
            'price_for_one.*'=>'integer',
            'currencies_for_one'=>['required','array',function($attr,$value,$fail){
                $val=collect($value);
               if ($val->count()){
                   if ($val->count() !== $val->unique()->count()){
                       $fail('Currencies for one should be unique');
                   }
               }
            }],
            'currencies_for_one.*'=>[Rule::in(Price::CURRENCIES)],
            'general_file'=>'required|file',
            'files'=>['present','array'],
            'files.*'=>'file',
            'colors'=>['required','string',function($attr,$value,$fail){
                $colors=json_decode($value);
                foreach ($colors as $color){
                    if (!$this->colors->contains($color)){
                        $fail('Wrong color provided');
                        return;
                    }
                }
            }],
            'sizes'=>['required','string',function($attr,$value,$fail){
                $sizes=json_decode($value);
                foreach ($sizes as $size){
                    if (!$this->sizes->contains($size)){
                        $fail('Wrong size provided');
                        return;
                    }
                }
            }],
            'metaDataName'=>['nullable','array',function($attr,$value,$fail){
                $val=collect($value);
                if ($val->count()){
                    if ($val->count() !== $val->unique()->count()){
                        $fail('Metadata names  should be unique');
                    }
                }
            }],
            'metaDataValue'=>'nullable|array',
            'metaDataName.*'=>'string',
            'metaDataValue.*'=>'string',
            'prices'=>'array|required_with_all:count_max,counts_min,currencies',
            'count_max'=>'array|required_with_all:prices,counts_min,currencies',
            'counts_min'=>'array|required_with_all:prices,counts_min,currencies',
            'currencies'=>['array','required_with_all:count_max,counts_min,prices',function($attr,$value,$fail){
                if (count($value)){
                    $counts_min=$this->get('count_min');
                    $counts_max=$this->get('count_max');
                    $prices=$this->get('prices');
                    if (!(count($value) ===count($counts_max) &&
                        count($counts_min)===count($prices) &&
                        count($counts_min)=== count($value))){
                        $fail('Provided parameters count of `prices for many ` does not match');
                        return;
                    }

                }
            }],

        ];
    }


    private function withValidator(Validator $validator):void
    {
        $validator->after(function (Validator $validator){
            $counts_min=$this->get('count_min');
            $counts_max=$this->get('count_max');
            $prices=$this->get('prices');
            $currencies=$this->get('currencies');
            $pricesData=[];
            foreach ($counts_min as $key => $value){
                $item=[];
                $item['min']=$value;
                $item['max']=$counts_max[$key];
                $item['price']=$prices[$key];
                $item['currency']=$currencies[$key];
                $pricesData[]=$item;
            }
            $pricesData=collect($pricesData);
            if ($pricesData->count() !== $pricesData->unique()->count()){
                $validator->errors()->add('Prices for many','Provided data of prices for many should be unique');
            };
        });
    }


    private function checkIfPricesForManyIsOk(array $prices):bool
    {
        
    }
}
