<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class RatingResource
 * @package App\Http\Resources\RatingResource
 *
 * @OA\Schema(
 *     type="object",
 *     schema="RatingResource",
 *     @OA\Property(property="rate",description="The average rating of this product (1 to 5).",type="float",example="3.6"),
 *     @OA\Property(property="count",description="The number of people that have rated this product.",type="float",example=155)
 * )
 */
class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "rate" => $this->rate,
            "count" => $this->count,
        ];
    }
}
