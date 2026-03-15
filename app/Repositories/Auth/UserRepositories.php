<?php

namespace App\Repositories\Auth;

use App\Models\User;
use App\Contracts\Repositories\Auth\UserRepositoriesInterface;

class UserRepositories implements UserRepositoriesInterface
{
    public function create(array $data)
    {
        return User::create($data);
    }
    public function findByEmail(string $email): ?User
    {
        return User::where('email',$email)->first();
    }
    public function getProfile(int $id)
    {
        return User::findOrFail($id);
    }

    public function updateProfile(int $id, array $data)
    {
        $user = User::findOrFail($id);

        $user->update($data);

        return $user;
    }
}
