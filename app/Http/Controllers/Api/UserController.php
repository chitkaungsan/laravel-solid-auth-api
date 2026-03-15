<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\ChangePasswordRequest;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function profile(Request $request)
    {
        $user = $this->userService->getProfile($request->user());
        return new UserResource($user);
    }
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = $this->userService->updateProfile($request->user(), $request->all());
        return new UserResource($user);
    }
    public function changePassword(ChangePasswordRequest $request)
    {
        $this->userService->changePassword(
            $request->user(),
            $request->current_password,
            $request->password
        );

        return response()->json([
            'message' => 'Password updated successfully'
        ]);
    }
}
