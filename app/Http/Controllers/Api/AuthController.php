<?php

namespace App\Http\Controllers\Api;

use App\Contracts\Traits\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function login(LoginRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        if (! Auth::attempt($validatedData)) {
            return $this->error("Invalid credentials.", 401);
        }

        $user = User::firstWhere('email', $validatedData['email']);

        return $this->success("Successfully authenticated", [
            'token' => $user->createToken(
                'API Token for ' . $user->email,
                ['*'],
                now()->addDay()
            )->plainTextToken
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success('Successfully logout');
    }
}
