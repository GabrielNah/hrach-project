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
            'name'=>'string|required',
            'title'=>'required|string',
            'description'=>'required|string',
            'is_active'=>[Rule::in(['on','off'])],
            'in_stock'=>[Rule::in(['yes','no'])],
            'rating'=>'required|numeric|min:1|max:5',
            'tags'=>'array|nullable',
            'tags.*'=>'integer|exists:tags,id',
            'prices.*'=>'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'price_for_one'=>'numeric|regex:/^\d+(\.\d{1,2})?$/',
            'general_file'=>'required|file',
            'files'=>['present','array'],
            'files.*'=>'file',
            'colors'=>['nullable','array',function($attr,$value,$fail){
                foreach ($value as $color){
                    if (!$color){
                        continue;
                    }
                    if (!$this->colors->contains($color)){
                        $fail('Wrong color provided');
                        return;
                    }
                }
            }],
            'sizes'=>['nullable','array',function($attr,$value,$fail){
                foreach ($value as $size){
                    if (!$size){
                        continue;
                    }
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
            'individual_size_name'=>['nullable','array',function($attr,$val,$fail){
                $size_names = collect($val);
                if($size_names->count() !== $size_names->unique()->count()){
                    $fail('Size names should be unique');
                }
            }],
            'individual_colors_name'=>['nullable','array',function($attr,$val,$fail){
                $size_names = collect($val);
                if($size_names->count() !== $size_names->unique()->count()){
                    $fail('Size names should be unique');
                }
            }],
            'individual_colors'=>['array','required_with:individual_colors_name',function($attr,$val,$fail){
                if (count($val)!== count($this->get('individual_colors_name'))){
                    $fail('Every individual color should have it`s own unique name');
                }
            }],
            'individual_colors.*'=>'image',
            'prices'=>['array','required_with_all:count_max,counts_min', function ($attribute, $value, $fail) {
                $prices = collect($value)->map(function ($val,$index){
                    $price=[];
                    $price['price']=$val;
                    $price['min_count']=$this->get('counts_min')[$index];
                    $price['max_count']=$this->get('count_max')[$index];
                    return $price;
                })->sortBy(fn($pr)=>$pr['min_count'])->values()->all();

                foreach ($prices as $index => $price){
                    $prev = $prices[$index - 1] ?? null;
                    $next = $prices[$index + 1] ?? null;
                    $showableIndex=$index+1;
                    if ($price['min_count'] >= $price['max_count']){
                        $fail('Min count of price should be less then max count of price');
                        return;
                    }
                    if (isset($prev) && $prev['max_count'] >= $price['min_count']) {

                        $fail('min_count', "The minimum count of the $showableIndex-th price overlaps with the maximum count of the previous price.");
                        return;
                    }
                    if (isset($next) && $price['max_count'] && $price['max_count'] >= $next['min_count']) {
                        $fail('max_count', "The maximum count of the $showableIndex-th price overlaps with the minimum count of the next price.");
                        return ;
                    }
                }

            }],
            'count_max'=>'array|required_with_all:prices,counts_min',
            'count_max.*'=>'nullable|integer',
            'counts_min.*'=>'integer',
            'counts_min'=>'array|required_with_all:prices,counts_min',
        ];
    }



    private function modifyPriceData():void
    {
        $prices = [];
        $price_for_one=[];
        $price_for_one['price']=$this->get('price_for_one');
        $price_for_one['min_count']=1;
        $price_for_one['max_count']=1;
        $prices[]=$price_for_one;

        foreach ($this->get('prices') as $index => $price){
            $price_data=[];
            $price_data['price']=$price;
            $price_data['min_count']=$this->get('counts_min')[$index];
            $price_data['max_count']=$this->get('count_max')[$index];
            $prices[]=$price_data;
        }

            $this->merge([
                'prices' => $prices
            ]);

    }
    private function modifyProductData():void
    {
        $name=$this->input('name');
        $description=$this->input('description');
        $category_id=$this->input('category');
        $rating=$this->input('rating');
        $active=$this->input('is_active')==='on'?'1':'0';
        $in_stock=$this->input('in_stock')==='yes';
        $title=$this->input('title');

        $this->merge([
            'product_data'=>compact('name','description','title','category_id','active','rating','in_stock')
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
