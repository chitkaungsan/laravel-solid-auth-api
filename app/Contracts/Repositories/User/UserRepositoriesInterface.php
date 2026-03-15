<?php

namespace App\Contracts\Repositories\User;
use App\Models\User;
interface UserRepositoriesInterface
{
    public function getProfile(int $id);

    public function updateProfile(int $id, array $data);

    public function updatePassword($userId, $password);

    public function findById($userId);
}
