<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProductService
{
    private $getProductsApi;
    private $categoryService;

    /**
     * Create a new Product Service instance.
     */
    public function __construct(CategoryService $categoryService)
    {
        $this->getProductsApi = 'https://fakestoreapi.com/products';
        $this->categoryService = $categoryService;
    }

    public function findById(int $productId)
    {
        return Product::find($productId);
    }

    /**
     * Update product's data
     * @param Request $request
     * @param \App\Models\Product $product
     * @return bool
     */
    public function update(Request $request, Product $product): bool
    {
        return $product->update($request->validated());
    }

    /**
     * Create if product doesn't exist, update if it does
     * @param array $productPayload
     * @return Product
     */
    public function createOrUpdate(array $productPayload)
    {
        return Product::updateOrCreate(['id' => $productPayload['id']],$productPayload);
    }

    /**
     * Create products in our DB from the incoming data
     * @param array $productPayload
     * @return void
     */
    public function importProducts(array $productPayload): void
    {
        $category = $this->categoryService->findByTitle($productPayload['category']);

        if(!$category) {
            $category = $this->categoryService->create($productPayload['category']);
        }

        $productPayload['category_id'] = $category->id;
        $product = $this->createOrUpdate($productPayload);

        $product->rating()->create($productPayload['rating']);
    }
}
