<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * The payload that should be sent to update a specific product
 *
 * @package App\Http\Requests
 *
 * @property string $title
 * @property string $description
 * @property string $image
 * @property float $price
 *
 * @OA\Schema(
 *     type="object",
 *     schema="UpdateProductRequest",
 *     required={"title", "description", "image", "price"},
 *     @OA\Property(property="title",description="The label or the key that identifies the product.",type="string", example="Woman's clothing"),
 *     @OA\Property(property="description",description="The description of the product",type="string", example="Woman's clothing description...")),
 *     @OA\Property(property="image",description="The image of the product",type="string", example="https://test.test/img.png")),
 *     @OA\Property(property="price",description="The price of the product.",type="float", example="50.99"),
 * )
 *
 */
class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "title" => ["required", "string", "max:255"],
            "description" => ["required", "string", "max:5000"],
            "price" => ["required", "numeric"],
            "image" => ["required", "string", "max:500"]
        ];
    }
}
