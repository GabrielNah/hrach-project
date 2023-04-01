<?php

namespace App\Api\V1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
{
    public function toArray($request):array
    {
        return  [
            'id'=>$this->resource->id,
            'currency'=>$this->resource->currency,
            'max_count'=>$this->resource->max_count,
            'min_count'=>$this->resource->min_count,
            'price'=>$this->resource->price,
        ];
    }

    public static function collection($resource)
    {
        $collection = parent::collection($resource);

        return collect($collection)->sortBy('min_count')->groupBy('currency');
    }
}
