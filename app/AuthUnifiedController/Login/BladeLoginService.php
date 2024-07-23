<?php

namespace App\AuthUnifiedController\Login;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class BladeLoginService
{
    public function login(LoginRequest $request)
    {
        $validatedData = $request->validated();

        $user = User::where('email', $validatedData['email'])->first();

        if ($user && Hash::check($validatedData['password'], $user->password)) {

            Auth::login($user);

            return redirect()->route('tasks.index');
        } else {
            return redirect()->back()->withErrors(['login' => 'Invalid credentials.']);
        }
    }



    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
