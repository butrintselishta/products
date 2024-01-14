<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UsersTest extends TestCase
{
    use RefreshDatabase, WithFaker;
    /**
     * User register test
     */
    public function test_register(): void
    {
        $requestData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/register', $requestData);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['data', 'statusCode']);
    }
}
