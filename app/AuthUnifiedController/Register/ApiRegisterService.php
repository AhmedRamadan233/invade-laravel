<?php

namespace App\AuthUnifiedController\Register;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ApiRegisterService
{
    public function register(RegisterRequest $request)
    {

        $validatedData = $request->validated();

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);
        $token = $user->createToken('user', ['app:all']);

        return response()->json([
            'token' => $token->plainTextToken,
            'success' => 'New account successfully created',
        ], 200);
    }
}
