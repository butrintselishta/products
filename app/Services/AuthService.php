<?php

namespace App\Services;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    /**
     * Handle an authentication attempt.
     * @param \Illuminate\Http\Request $request
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     * @return string
     */
    public function login(Request $request): string
    {
        $credentials = $request->only('email', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            throw new UnauthorizedHttpException("","Invalid credentials");
        }

        return $token;
    }

    /**
     *
     * Handle a register request attempt.
     * @param \Illuminate\Http\Request $request
     * @throws \Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException
     * @return UserResource
     */
    public function register(Request $request): UserResource
    {
        $payload = $request->validated();

        $user = User::create($payload);

        return new UserResource($user);
    }
}
