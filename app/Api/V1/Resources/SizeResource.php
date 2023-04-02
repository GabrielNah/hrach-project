<?php

namespace App\Api\V1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SizeResource extends JsonResource
{
    public function toArray($request):array
    {
        return [
            'id' => $this->resource->id,
            'size' => $this->resource->size,
        ];
    }
}
