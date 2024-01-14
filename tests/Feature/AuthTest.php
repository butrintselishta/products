<?php

namespace Tests\Feature;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test login
     */
    public function test_login(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['data', 'statusCode']);
    }

    /**
     * Test register
     */
    public function test_register(): void
    {
        $requestData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password',
        ];

        $response = $this->postJson('/api/register', $requestData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('users', ['email' => $requestData['email']]);
        $user = User::where('email', $requestData['email'])->first();
        $userResource = new UserResource($user);
        $userArray = $userResource->toArray();
        $response->assertEquals($userResource->name);
        $response->assertEquals($userResource->email);
    }
}
