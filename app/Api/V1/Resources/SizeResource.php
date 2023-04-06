<?php

namespace App\Api\V1\Resources;

use App\Models\Size;
use Illuminate\Http\Resources\Json\JsonResource;

class SizeResource extends JsonResource
{
    public function toArray($request):array
    {
        return [
            'id' => $this->resource->id,
            'size' => $this->resource->size,
            'individual'=>$this->resource->type === Size::TYPE_INDIVIDUAL,
        ];
    }
}
