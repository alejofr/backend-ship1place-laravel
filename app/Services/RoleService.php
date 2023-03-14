<?php

namespace App\Services;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleService{
    
    public static function assing(Int $idRole, string $type, User $user) : User
    {
        $role = self::getRole($idRole, $type);

        return $user->assignRole($role);
    }

    public static function getRole(Int $idRole, string $type)
    {
        return Role::findById($idRole, $type);
    }
}