<?php

namespace App\Api\V1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{

    public function toArray($request):array
    {
        return [
            'id'=>$this->resource->id,
            'name'=>$this->resource->name,
            'description'=>$this->resource->description,
        ];

    }
}
