<?php

namespace App\AuthUnifiedController\Register;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BladeRegisterService
{
    public function register(RegisterRequest $request)
    {
        $ValidatedData = $request->validated();
        $password = Hash::make($ValidatedData['password']);
        $user = User::create($ValidatedData);

        return redirect()->route('login');
    }
}
