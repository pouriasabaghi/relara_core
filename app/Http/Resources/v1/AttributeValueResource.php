<?php
namespace App\Http\Resources\v1;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeValueResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'attribute_id' => $this->attribute_id,
            'attribute_name' => $this->attribute->name, 
            'value' => $this->value,
        ];
    }
}
