<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\UserAuthRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\JsonResponse;


class UserAuthController extends Controller
{
    public function createToken(UserAuthRequest $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'email' => 'required|string|email|unique:users',
                'password' => 'required|min:8'
            ]);

            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // Create token
            $token = $user->createToken('AuthToken')->plainTextToken;

            return response()->json([
                'message' => 'User registered',
                'success' => true,
                'token' => $token,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'success' => false,
            ]);
        }
    }
    public function register(UserAuthRequest $request)
    {
        // TODO implement register base on cookie
    }

    public function login(UserAuthRequest $request): JsonResponse
    {
        try {
            $data = $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|min:8'
            ]);

            // Check user credentials
            $user = User::where('email', $data['email'])->first();
            if (!$user || !Hash::check($data['password'], $user->password)) {
                throw new \Exception('Invalid credentials', 401);
            }

            // Create token
            $token = $user->createToken('AuthToken')->plainTextToken;

            return response()->json([
                'token' => $token,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'success' => false,
            ]);
        }
    }


    public function logout(): JsonResponse
    {
        try {
            auth()->user()->tokens()->delete();

            return response()->json([
                "message" => "logged out",
                "success" => 'true',
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
                'success' => false,
            ]);
        }
    }
}
