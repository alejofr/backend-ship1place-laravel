<?php 

namespace App\Interfaces;

use App\Models\User;
use App\Repositories\UserRepository;

interface StoreUserInterface{
    public static function store($userData, UserRepository $userRepository) : User;
}