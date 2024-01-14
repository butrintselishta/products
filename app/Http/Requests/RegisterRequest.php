<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

/**
 * The payload that should be sent to register a new user in DB
 *
 * @package App\Http\Requests
 *
 * @property string $name
 * @property string $email
 * @property string $password
 *
 * @OA\Schema(
 *     type="object",
 *     schema="UserRegister",
 *     required={"name", "email", "password"},
 *     @OA\Property(property="name",description="The name that identifies the user.",type="string", example="Butrint"),
 *     @OA\Property(property="email",description="The email of the product that he will use to login",type="string", example="test@test.com")),
 *     @OA\Property(property="password",description="The password that the user will use to log in.",type="string", example="12341234")),
 * )
 *
 */
class RegisterRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => ["required", "string"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "string"],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();
        $validated['password'] = Hash::make($validated['password']);

        return $validated;
    }
}
