<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources\UserResource
 *
 * @OA\Schema(
 *     type="object",
 *     schema="UserResource",
 *     @OA\Property(property="name",description="The name of the user.",type="string",example="Test 1"),
 *     @OA\Property(property="email",description="The email of the user.",type="string",example="test@test.com")
 * )
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->name,
            "email" => $this->email,
        ];
    }
}
