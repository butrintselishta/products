<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

class ProductsTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_update_product(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $product = Product::factory()->create();
        $updatedData = [
            'title' => $this->faker->word,
            'description' => $this->faker->sentence,
            'price' => $this->faker->randomFloat(2, 1, 100),
            'image' => $this->faker->imageUrl(),
        ];

        $token = JWTAuth::fromUser($user);        ;

        $response = $this->putJson("/api/products/{$product->id}", $updatedData, [
            'Authorization' => 'Bearer ' . $token
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['data', 'statusCode']);
    }
}
