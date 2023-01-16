<?php

namespace App\Http\Controllers;

use App\Services\ProfileUserService;
use Illuminate\Http\Request;

class ProfileUserController extends Controller
{
    public function __construct(ProfileUserService $profileUserService)
    {
        $this->profileUserService = $profileUserService;
    }

    public function show($id, Request $request)
    {
        return $this->profileUserService->getById($id, $request);
    }

    public function update($id, Request $request)
    {
        return $this->profileUserService->updateById($id, $request);
    }
}
