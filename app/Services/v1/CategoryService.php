<?php

namespace App\Services\v1;

use App\Models\Category;

class CategoryService
{
    /**
     * Create or update a category.
     */
    public function saveCategory(array $data, ?int $id = null): Category
    {
        return Category::updateOrCreate(
            ['id' => $id],
            ['name' => $data['name'], 'parent_id' => $data['parent_id'] ?? null]
        );
    }

    /**
     * Delete a category and its children.
     */
    public function deleteCategory(int $id): bool
    {
        $category = Category::findOrFail($id);
        return $category->delete();
    }

    /**
     * Summary of getCategoryById
     * @param int $id
     * @param Category|null 
     */
    public function getCategoryById(int $id): Category|null
    {
        $category = Category::with('children')->find($id);

        return $category;
    }

    /**
     * Get categories with their nested children.
     */
    public function getCategoriesWithChildren()
    {
        return Category::with('children')->whereNull('parent_id')->get();
    }
}
