<?php

namespace App\Services\v1;

use App\Models\Product;

class ProductService
{
    protected $productImageService;
    public function __construct(){
        $this->productImageService = new ProductImageService();
    }
    public function getAll()
    {
        return Product::with(['categories', 'variants', 'images'])->get();
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

        if(!empty($data['images'])) {
            $this->productImageService->create($product, $data['images']);
        }

        return $product;
    }

    public function getById(int $id): Product
    {
        return Product::with(['categories', 'variants', 'images'])->findOrFail($id);
    }

    public function update(int $id, array $data): Product
    {
        $product = $this->getById($id);

        $product->update([
            'name' => $data['name'],
            'desc' => $data['desc'] ?? null,
        ]);

        if (isset($data['categories'])) {
            $product->categories()->sync($data['categories']);
        }

        if(isset($data['images'])) {
            $this->productImageService->update($product, $data['images']);
        }

        return $product->refresh();
    }

    public function delete(int $id): void
    {
        $product = $this->getById($id);
        $product->delete();
    }
}
