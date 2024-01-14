<?php

namespace App\Services;

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

        try{
            if (!$token = JWTAuth::attempt($credentials)) {
                throw new UnauthorizedHttpException("","Invalid credentials");
            }

            return $token;
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Handle an logout attempt.
     * @return void
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
    }
}
