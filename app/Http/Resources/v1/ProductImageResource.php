<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'is_primary' => $this->is_primary,
            'path' => $this->path,
            'url' => url("storage/$this->path"),
            'sizes' => $this->sizes?->mapWithKeys(fn($size) => [$size->size => new ImageResource($size)]),
        ];
    }
}
