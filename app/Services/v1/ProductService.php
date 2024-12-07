<?php

namespace App\Services\v1;

use App\Models\Product;

class ProductService
{
    public function getAll()
    {
        return Product::with(['categories', 'variants'])->get();
    }

    public function create(array $data): Product
    {
        $product = Product::create([
            'name' => $data['name'],
            'desc' => $data['desc'] ?? null,
        ]);

        if (!empty($data['categories'])) {
            $product->categories()->sync($data['categories']);
        }

        return $product;
    }

    public function getById(int $id): Product
    {
        return Product::with(['categories', 'variants'])->findOrFail($id);
    }

    public function update(int $id, array $data): Product
    {
        $product = $this->getById($id);

        $product->update([
            'name' => $data['name'],
            'description' => $data['description'] ?? null,
        ]);

        if (!empty($data['categories'])) {
            $product->categories()->sync($data['categories']);
        }

        return $product->refresh();
    }

    public function delete(int $id): void
    {
        $product = $this->getById($id);
        $product->delete();
    }
}
