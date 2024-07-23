<?php

namespace App\Http\Controllers\Auth;

use App\AuthUnifiedController\Login\ApiLoginService;
use App\AuthUnifiedController\Login\BladeLoginService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    protected $bladeLoginService;
    protected $apiLoginService;
    public function __construct(BladeLoginService $bladeLoginService, ApiLoginService $apiLoginService)
    {
        $this->bladeLoginService = $bladeLoginService;
        $this->apiLoginService = $apiLoginService;
    }
    public function index()
    {
        return view('Auth.login');
    }
    public function login(LoginRequest $request)
    {
        if ($request->is('api/*')) {

            return $this->apiLoginService->login($request);
        } else {
            return $this->bladeLoginService->login($request);
        }
    }



    public function logout(Request $request)
    {
        if ($request->is('api/*')) {
            return $this->apiLoginService->logout($request);
        } else {
            return $this->bladeLoginService->logout($request);
        }
    }
}
