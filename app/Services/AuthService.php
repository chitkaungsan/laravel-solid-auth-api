<?php

namespace App\Services;

use App\Contracts\Repositories\Auth\UserRepositoriesInterface;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $users;

    public function __construct(UserRepositoriesInterface $users)
    {
        $this->users = $users;
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        $user = $this->users->create($data);

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    public function login(array $data)
    {
        $user = $this->users->findByEmail($data['email']);

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return null;
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }
    public function profile($user)
    {
        return $user;
    }
}
