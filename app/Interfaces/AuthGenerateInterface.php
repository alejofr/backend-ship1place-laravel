<?php 

namespace App\Interfaces;

use App\Models\User;

interface AuthGenerateInterface{
    public static function generate(User $user);
}