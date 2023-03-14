<?php

namespace App\Services\User;

use App\Interfaces\StoreUserInterface;
use App\Models\User;
use App\Repositories\UserRepository;

class StoreClientService implements StoreUserInterface{
    public static function store($userData, UserRepository $userRepository) : User
    {
        $userClient = $userRepository->createUser($userData);
        $userClient->assignRole('Client');

        return $userClient;
    }
}


