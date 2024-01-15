<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    /**
     * Find category by title
     * @param string $categoryTitle
     * @return Category
     */
    public function findByTitle(string $categoryTitle): Category|null
    {
        return Category::where('title', $categoryTitle)->first();
    }

    /**
     * Create new Category in our database
     * @param string $categoryTitle
     * @return Category
     */
    public function create(string $categoryTitle): Category
    {
        return Category::create(['title' => $categoryTitle]);
    }
}
