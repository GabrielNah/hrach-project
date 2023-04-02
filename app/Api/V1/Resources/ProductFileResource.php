<?php

namespace App\Api\V1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductFileResource extends JsonResource
{
    public function toArray($r):array
    {
        return [
            'id' => $this->resource->id,
            'path'=>$this->resource->path,
            'type'=>$this->resource->type,
            'general'=>(bool) $this->resource->general
        ];
    }

}
