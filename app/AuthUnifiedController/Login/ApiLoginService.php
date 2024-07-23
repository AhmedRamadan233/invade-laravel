<?php

namespace App\AuthUnifiedController\Login;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ApiLoginService
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            $user = User::find(auth()->id());
            $user->tokens()->delete();
            $token = $user->createToken(request()->userAgent());

            return response()->json([
                'token' => $token->plainTextToken,
                'success' => "Login successful",
            ], 200);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Logout successful'
        ], 200);
    }
}
