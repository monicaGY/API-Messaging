<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Info(
 *     title="API - Messaging",
 *     version="1.0",
 *     description=""
 * )
 *
 * @OA\Server(
 *     url="http://127.0.0.1:8000",
 *     description="Server local"
 * )
 */

class AuthController
{
    /**
     * @OA\PathItem(
     *     path="/auth"
     * )
     */

    /**
     * @OA\Post(
     *     path="/auth/login",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"email", "password"},
     *                  @OA\Property(property="email", type="string", example="sebastian.garcia@gmail.com"),
     *                  @OA\Property(property="password", type="string", example="sebastian2025!")
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Login successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="your-token-here")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Invalid credentials"
     *     )
     * )
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'User does not exist'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token
        ]);
    }
    /**
     * @OA\Post(
     *     path="/auth/register",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"name","email", "password"},
     *                  @OA\Property(property="name", type="string", example="Sebastian"),
     *                  @OA\Property(property="email", type="string", example="sebastian.garcia@gmail.com"),
     *                  @OA\Property(property="password", type="string", example="sebastian2025!")
     *              )
     *          )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Register successful",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", example="your-token-here")
     *         )
     *     )
     * )
     */

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token
        ], 201);
    }
}
