<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function createUser(User $user): User
    {
        $user->save();
        $user->refresh();

        return $user;
    }
}
