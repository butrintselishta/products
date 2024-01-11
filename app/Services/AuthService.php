<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
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
}
