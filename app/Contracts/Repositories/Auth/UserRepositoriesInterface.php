<?php

namespace App\Contracts\Repositories\Auth;
use App\Models\User;
interface UserRepositoriesInterface
{
    public function create(array $data);

    public function findByEmail(string $email): ?User;

    public function getProfile(int $id);

    public function updateProfile(int $id, array $data);
}
