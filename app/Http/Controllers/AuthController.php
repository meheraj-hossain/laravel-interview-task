<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\AuthResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): AuthResource|JsonResponse
    {
        try {
            $result = $this->authService->registerUser($request->validated());

            return new AuthResource($result);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'Registration failed!',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(LoginRequest $request): AuthResource|JsonResponse
    {
        try {
            if (!$token = JWTAuth::attempt($request->validated())) {
                return response()->json(['error' => 'Invalid credentials!'], 401);
            }

            return new AuthResource(['user' => Auth::user(), 'token' => $token]);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'Login failed!',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->authService->logoutUser();

            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (\Throwable $e) {
            return response()->json([
                'error'   => 'Logout failed!',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}

