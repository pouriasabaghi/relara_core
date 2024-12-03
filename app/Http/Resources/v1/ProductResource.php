<?php
namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'variants' => ProductVariantResource::collection($this->whenLoaded('variants')),
        ];
    }
}
