<?php

namespace App\Repositories\User;

use App\Models\User;
use App\Contracts\Repositories\User\UserRepositoriesInterface;
use Illuminate\Support\Facades\Hash;


class UserRepositories implements UserRepositoriesInterface
{
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
    public function findById($userId)
    {
        return User::findOrFail($userId);
    }

    public function updatePassword($userId, $password)
    {
        $user = User::findOrFail($userId);

        $user->password = Hash::make($password);
        $user->save();

        return $user;
    }
}
