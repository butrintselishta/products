<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserService
{
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

        try {
            $user = User::create($payload);

            return new UserResource($user);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
