<?php

namespace App\Api\V1\Resources;

use App\Models\Color;
use Illuminate\Http\Resources\Json\JsonResource;

class ColorResource extends JsonResource
{
    public function toArray($request):array
    {
        return [
            'id'=>$this->resource->id,
            'name'=>$this->resource->name,
            'value'=>$this->resource->value,
            'individual'=>$this->resource->type === Color::TYPE_INDIVIDUAL,
        ];

    }
}
