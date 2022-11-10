<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(private readonly UserRepository $repository)
    {
    }

    public function registerUser(string $name, string $email, string $password): ?User
    {
        $model = new User([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);

        try {
            return $this->repository->createUser($model);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
