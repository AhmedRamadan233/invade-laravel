<?php

namespace App\Http\Controllers\Auth;

use App\AuthUnifiedController\Register\ApiRegisterService;
use App\AuthUnifiedController\Register\BladeRegisterService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    protected $bladeRegisterService;
    protected $apiRegisterService;

    public function __construct(BladeRegisterService $bladeRegisterService, ApiRegisterService $apiRegisterService)
    {
        $this->bladeRegisterService = $bladeRegisterService;
        $this->apiRegisterService = $apiRegisterService;
    }
    public function index()
    {
        return view('Auth.register');
    }
    public function register(RegisterRequest $request)
    {
        if ($request->is('api/*')) {
            return $this->apiRegisterService->register($request);
        } else {
            return $this->bladeRegisterService->register($request);
        }
    }
}
