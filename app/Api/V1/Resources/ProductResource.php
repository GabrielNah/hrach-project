<?php

namespace App\Api\V1\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request):array
    {
        return [
            'id'  => $this->resource->id,
            'additional'   =>json_decode($this->resource->additional->additional,true),
            'general_file' =>$this->whenLoaded(
                'generalFile',
                ProductFileResource::make($this->resource->generalFile),
            ),
            'non_general_files' =>$this->whenLoaded(
                'nonGeneralFiles',
                ProductFileResource::collection($this->resource->nonGeneralFiles)
            ),
            'prices' => PriceResource::collection($this->resource->prices),
            'rating' => (int) $this->resource->rating,
            'active' => $this->resource->active,
            'in_stock' => $this->resource->in_stock,
            'description' => $this->resource->description,
            'name' => $this->resource->name,
            'title' => $this->resource->title,
            'colors' => ColorResource::collection($this->resource->colors),
            'sizes' => SizeResource::collection($this->resource->sizes),
            'tags'=> TagResource::collection($this->resource->tags),
            'category'=>CategoryResource::make($this->resource->category),
            'comments'=>$this->resource->comments ?? []
        ];
    }
}
