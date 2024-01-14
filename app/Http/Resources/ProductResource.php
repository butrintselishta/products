<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class ProductResource
 * @package App\Http\Resources\ProductResources
 *
 * @property int id
 * @property string title
 * @p
 *
 * @OA\Schema(
 *     type="object",
 *     schema="ProductResource",
 *     @OA\Property(property="id",description="The primary key of the table, serving as a unique identifier for each product record.",type="integer",example=1),
 *     @OA\Property(property="title",description="The label or the name that identifies an product.",type="string",example="T Shirt Casual"),
 *     @OA\Property(property="price",description="The price of this product.",type="float",example=120.2),
 *     @OA\Property(property="description",description="The description of the product",type="string",example="95% Cotton,5% Spandex, Features: Casual"),
 *     @OA\Property(property="category",description="The category of the product",type="string",example="Men's clothing"),
 *     @OA\Property(property="image",description="The image of th eproduct",type="string"),
 *     @OA\Property(property="rating",description="The track of rating of this product",type="array",@OA\Items(ref="#/components/schemas/RatingResource"))
 * )
 */
class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'price' => $this->price,
            'description' => $this->description,
            'category' => $this->category->title,
            'image' => $this->image,
            'rating' => new RatingResource($this->rating),
        ];
    }
}
