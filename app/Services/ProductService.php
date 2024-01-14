<?php

namespace App\Services;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

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
     * @return ProductResource
     */
    public function update(Request $request, Product $product): ProductResource
    {
        $product->update($request->validated());
        return new ProductResource($product);
    }

    /**
     * Create if product doesn't exist, update if it does
     * @param array $productPayload
     * @return Product
     */
    public function updateOrCreate(array $productPayload)
    {
        return Product::updateOrCreate(['id' => $productPayload['id']], $productPayload);
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
        $product = $this->updateOrCreate($productPayload);

        $product->rating()->create($productPayload['rating']);
    }
}
