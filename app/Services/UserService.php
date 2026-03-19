<?php

namespace App\Services;

use App\Contracts\Repositories\User\UserRepositoriesInterface;
use Illuminate\Support\Facades\Hash;
use Exception;

class UserService
{
    protected $user;

    public function __construct(UserRepositoriesInterface $user)
    {
        $this->user = $user;
    }

    public function getProfile($user)
    {
        return $this->user->getProfile($user->id);
    }

    public function updateProfile($user, array $data)
    {
        return $this->user->updateProfile($user->id, $data);
    }
    public function changePassword($user, $currentPassword, $newPassword)
    {
        $user = $this->user->findById($user['id']);

        if (!Hash::check($currentPassword, $user->password)) {
            throw new Exception("Current password incorrect");
        }

        return $this->user->updatePassword($user['id'], $newPassword);
    }
    public function assignRole(int $userId, string $role)
    {
        $user = $this->user->findById($userId);

        if (!$user) {
            throw new \Exception("User not found");
        }

        $user->assignRole($role);

        return $user;
    }
}
