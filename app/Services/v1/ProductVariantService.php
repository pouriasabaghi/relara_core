<?php

namespace App\Services\v1;

use App\Models\ProductVariant;

class ProductVariantService
{
    public function getAll()
    {
        return ProductVariant::with(['product', 'attributeValues'])->get();
    }

    public function create(array $data): ProductVariant
    {
        $variant = ProductVariant::create([
            'product_id' => $data['product_id'],
            'price' => $data['price'] ?? 0,
            'stock' => $data['stock'] ?? 0,
            'status' => $data['status'] ?? 'available',
        ]);

        $variant->attributeValues()->sync($data['attribute_values']);

        return $variant;
    }

    public function getById(int $id): ProductVariant
    {
        return ProductVariant::with(['product', 'attributeValues'])->findOrFail($id);
    }

    public function update(int $id, array $data): ProductVariant
    {
        $variant = $this->getById($id);

        $variant->update([
            'price' => $data['price'] ?? 0,
            'stock' => $data['stock'] ?? 0,
            'status' => $data['status'] ?? 'available',
        ]);

        return $variant;
    }

    public function delete(int $id): void
    {
        $variant = $this->getById($id);
        $variant->delete();
    }
}
