<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductController extends Controller
{
    protected $productService;

    /**
     * Create a new Product Controller instance
     * @param \App\Services\ProductService $productService
     * @return void
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Summary of update
     * @param \App\Http\Requests\UpdateProductRequest $request
     * @param int $id
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        $product = $this->productService->findById($id);
        if(!$product) {
            throw new NotFoundHttpException('Product not found');
        }
        return response()->success($this->productService->update($request, $product));
    }
}
