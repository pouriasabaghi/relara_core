<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

    protected $fillable = ['name', 'parent_id'];

    /**
     * Define the parent-child relationship.
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Define the relationship to fetch children categories.
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('children');
    }
}
