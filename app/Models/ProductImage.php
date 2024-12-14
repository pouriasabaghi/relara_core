<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = ['product_id', 'is_primary', 'path'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function sizes()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
}
