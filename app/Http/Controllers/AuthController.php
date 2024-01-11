<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
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
     * @return mixed
     */
    public function login(Request $request)
    {
        return response()->success($this->authService->login($request));
    }
}
