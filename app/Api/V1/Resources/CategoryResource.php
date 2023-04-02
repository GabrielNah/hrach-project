<?php

namespace App\Api\V1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    public function toArray($request):array
    {
        return [
            'id'=>$this->resource->id,
            'name'=>$this->resource->name,
            'active'=>$this->resource->active,
            'parentCategory'=>static::make($this->resource->parentCategory)
        ];
    }

}
