<?php

namespace App\Services\v1;

use App\Models\Product;


class ProductImageService
{
    protected $imageService;
    public function __construct()
    {
        $this->imageService = new ImageService();
    }
    public function create(Product $product, array $images)
    {
        foreach ($images as $image) {
            $imagePath = $this->imageService->move($image['path'], 'products');
            
            // update image path after move 
            $image['path'] = $imagePath;

            $image = $product->images()->create($image);

            $resizeImagePaths = $this->imageService->resize($imagePath, 'products');

            if ($imagePath) {
                $image->sizes()->createMany($resizeImagePaths);
            }
        }
    }


    public function update(Product $product, array $images)
    {
        $product->images()->delete();
        $product->images()->createMany($images);
    }

}