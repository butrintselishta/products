<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Tymon\JWTAuth\Facades\JWTAuth;

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
    * Test logout.
    *
    */
    public function test_logout()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->json('POST', 'api/logout', [], [
            'Authorization' => 'Bearer ' . JWTAuth::fromUser($user)
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['data', 'statusCode']);
    }

}
