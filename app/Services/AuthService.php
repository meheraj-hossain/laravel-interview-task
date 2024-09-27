<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService
{
    public function registerUser(array $data): array
    {
        try {
            $user = User::create([
                'name'     => $data['name'],
                'email'    => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $token = JWTAuth::fromUser($user);

            return ['user' => $user, 'token' => $token];
        } catch (\Throwable $e) {
            throw new \Exception('Could not Register: ' . $e->getMessage());
        }
    }

    public function logoutUser(): void
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
        } catch (\Throwable $e) {
            throw new \Exception('Could not Logout: ' . $e->getMessage());
        }
    }

}
