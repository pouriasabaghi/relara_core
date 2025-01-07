<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    protected $fillable = [
        'code', 'type', 'value', 'min_cart_value', 'max_discount_value', 'usage_limit', 'expires_at',
    ];
}
