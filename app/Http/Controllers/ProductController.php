<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    /**
     * Create a new Product Controller instance
     * @param \App\Services\ProductService $productService
     * @return void
     */
    public function __construct(private ProductService $productService)
    {
        //
    }

    /**
     * Update a specific product in database
     *
     * @OA\Put (
     *     path="/api/products/{id}",
     *     operationId="updateProduct",
     *     tags={"Products"},
     *     description="This endpoint is used to update a specific product by providing the product id",
     *     security={{"jwt_token_security": {}}},
     *     @OA\Parameter(name="id",description="The primary key of the table, serving as a unique identifier for each product record.",required=true,in="path",@OA\Schema(type="integer", example=1)),
     *     @OA\RequestBody(required=true,@OA\JsonContent(ref="#/components/schemas/UpdateProductRequest")),
     *     @OA\Response(response=200,description="The client's request operation has been completed successfully.",@OA\JsonContent(ref="#/components/schemas/ProductResource")),
     *     @OA\Response(response=401,description="Authentication failed: Please ensure that you have provided valid credentials to access this resource!",@OA\JsonContent(ref="#/components/schemas/UnauthenticatedResponse")),
     *     @OA\Response(response=404,description="Resource not found: The requested resource was not found on the server!",@OA\JsonContent(ref="#/components/schemas/NotFoundResponse")),
     *     @OA\Response(response=422,description="Validation failed: The server could not process the request due to validation errors.",@OA\JsonContent(ref="#/components/schemas/FailedValidationResponse")),
     *     @OA\Response(response=500,description="Internal Server Error: There was an unexpected condition that prevented the server from fulfilling the API request. Please try again later!",@OA\JsonContent(ref="#/components/schemas/ServerErrorResponse"))
     * )
     *
     * @param \App\Http\Requests\UpdateProductRequest $request
     * @param int $id
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        return response()->success($this->productService->update($request, $id));
    }
}
