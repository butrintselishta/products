<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $authService;

    /**
     * Summary of __construct
     * @param \App\Services\AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle an authentication attempt.
     * @param \Illuminate\Http\Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        return response()->success($this->authService->login($request));
    }

    /**
     * Handle an logout attempt.
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout();
        return response()->success("User successfully logged out!");
    }
}
