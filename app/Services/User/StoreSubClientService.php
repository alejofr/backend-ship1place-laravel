<?php

namespace App\Services\User;

use App\Interfaces\StoreUserInterface;
use App\Models\User;
use App\Repositories\UserRepository;
use Spatie\Permission\Models\Role;

class StoreSubClientService implements StoreUserInterface{

    public static function store($userData, UserRepository $userRepository) : User
    {
        $userRepository->getUser($userData['user_id_parent']);

        $userSubClient = $userRepository->createUser($userData);

        return $userSubClient;
    }
}