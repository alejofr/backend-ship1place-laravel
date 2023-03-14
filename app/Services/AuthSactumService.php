<?php

namespace App\Services;

use App\Interfaces\AuthGenerateInterface;
use App\Models\User;

class AuthSactumService implements AuthGenerateInterface{

    public static function generate(User $user)
    {
        return [
            'user' => $user,
            'access_token' => $user->createToken('auth_token')->plainTextToken,
            'token_type' => 'Bearer'
        ];
    }
}