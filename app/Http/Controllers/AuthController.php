<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        return $this->authService->login($request);
    }

    public function register(Request $request)
    {
        return $this->authService->register($request);
    }

    public function logout()
    {
        return $this->authService->logout();
    }

    public function refresh(Request $request)
    {
        return $this->authService->refreshToken($request);
    }

    public function destroy($id, Request $request)
    {
        return $this->authService->destroy($id, $request);
    }
}
