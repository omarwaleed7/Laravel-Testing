<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\RegisterUserRequest;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Registers a user
     *
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->validated()['name'],
            'email' => $request->validated()['email'],
            'password' => Hash::make($request->validated()['password'])
        ]);

        return $this->successResponse('User registered successfully',$user,201);
    }

    /*
     * Login a user
     *
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $user = User::where('email',$request->validated()['email'])->first();
        if (!Hash::check($request->validated()['password'],$user->password)) {
            return $this->errorResponse('Invalid credentials',401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->successResponse('User logged in successfully',[
            'user' => $user,
            'token' => $token
        ],200);
    }
}
