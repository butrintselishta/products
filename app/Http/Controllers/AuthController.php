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
     * @OA\Post (
     *     path="/api/register",
     *     operationId="register",
     *     tags={"Users"},
     *     description="This endpoint is used to register a new user",
     *     security={{"jwt_token_security": {}}},
     *     @OA\RequestBody(required=true,@OA\JsonContent(ref="#/components/schemas/UserRegister")),
     *     @OA\Response(response=200,description="The client's request operation has been completed successfully.",@OA\JsonContent(ref="#/components/schemas/UserResource")),
     *     @OA\Response(response=422,description="Validation failed: The server could not process the request due to validation errors.",@OA\JsonContent(ref="#/components/schemas/FailedValidationResponse")),
     *     @OA\Response(response=500,description="Internal Server Error: There was an unexpected condition that prevented the server from fulfilling the API request. Please try again later!",@OA\JsonContent(ref="#/components/schemas/ServerErrorResponse"))
     * )
     *
     * Handle an request to register attempt.
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return response()->success($this->authService->register($request));
    }
}
