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
            'price_for_one'=>['required','array',function ($attribute, $value, $fail) {
                $prices = collect($value);
                $currencies = collect($this->input('currencies_for_one'));

                if ($prices->count() !== $currencies->count()) {
                    $fail('Number of prices and currencies should match');
                    return;
                }

                $objects = $prices->map(function ($price, $index) use ($currencies) {
                    return [
                        'price' => $price,
                        'currency' => $currencies[$index],
                    ];
                });

                if ($objects->count() !== $objects->unique()->count()) {
                    $fail('Prices and currencies should be unique');
                }
            },],
            'price_for_one.*'=>'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'currencies_for_one'=>['required','array'],
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
            'prices.*' => [
                'numeric',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'prices'=>['array','required_with_all:count_max,counts_min,currencies', function ($attribute, $value, $fail) {
                $minCounts = $this->get('counts_min');
                $maxCounts = $this->get('count_max');
                $currencies = $this->get('currencies');

                $pricesData = [];
                foreach ($minCounts as $index => $minCount) {
                    $currency = $currencies[$index];
                    if ($maxCounts[$index] < $minCount) {
                        $fail('min_count should be less than max_count');
                        return;
                    }

                    $priceData = [
                        'min_count' => $minCount,
                        'max_count' => $maxCounts[$index],
                        'price' => $value[$index],
                        'currency' => $currency,
                    ];

                    $pricesData[$currency][] = $priceData;
                }

                foreach ($pricesData as $currency => $priceArray) {
                    $uniquePriceArray = collect($priceArray)->unique();
                    if ($uniquePriceArray->count() !== count($priceArray)) {
                        $fail("Provided parameters count of `prices for many` does not match for currency $currency");
                    }
                }
            },],
            'count_max'=>'array|required_with_all:prices,counts_min,currencies',
            'counts_min'=>'array|required_with_all:prices,counts_min,currencies',
            'currencies'=>['array','required_with_all:count_max,counts_min,prices'],

        ];
    }



    private function modifyPriceData():void
    {
        $priceForOne = $this->input('price_for_one');
        $currenciesForOne = $this->input('currencies_for_one');
        $pricesForOne = [];

        if ($priceForOne && $currenciesForOne){
            foreach ($priceForOne as $key => $price) {
                $pricesForOne[] = [
                    'price' => $price,
                    'currency' => $currenciesForOne[$key]
                ];
            }

            $this->merge([
                'prices_for_one' => $pricesForOne
            ]);
        }


        $countsMin = $this->input('counts_min');
        $countsMax = $this->input('count_max');
        $currencies = $this->input('currencies');
        $prices = $this->input('prices');
        $pricesForMany = [];
        if ($countsMin && $countsMax && $currencies && $prices){
            foreach ($countsMin as $key => $countMin) {
                $pricesForMany[] = [
                    'min_count' => $countMin,
                    'max_count' => $countsMax[$key],
                    'price' => $prices[$key],
                    'currency' => $currencies[$key]
                ];
            }

            $this->merge([
                'prices_for_many' => $pricesForMany
            ]);
        }

    }
    private function modifyProductData():void
    {
        $name=$this->input('name');
        $description=$this->input('description');
        $category_id=$this->input('category');
        $rating=$this->input('rating');
        $active=$this->input('is_active')==='on'?'1':'0';
        $title=$this->input('title');
        $sizes=$this->input('sizes');
        $colors=$this->input('colors');

        $this->merge([
            'product_data'=>compact('name','description','title','category_id','active','sizes','colors','rating')
        ]);
    }


    private function combineMetaDats():void
    {
        $names=$this->get('metaDataName');
        $values=$this->get('metaDataValue');
        $additional=[];
        if ($names && $values){
            foreach ($names as $index=>$name){
                $additional[$name]=$values[$index];
            }
        }
        $this->merge([
            'additional'=>json_encode($additional)
        ]);
    }


    private function getMergedResult():array
    {

        $this->modifyPriceData();
        $this->modifyProductData();
        $this->combineMetaDats();
        return $this->all();
    }

    public function validated($key = null, $default = null):array
    {
        return $this->getMergedResult();
    }

}
