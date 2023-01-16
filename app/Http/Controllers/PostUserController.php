<?php

namespace App\Http\Controllers;

use App\Services\PostUserService;
use Illuminate\Http\Request;

class PostUserController extends Controller
{
    public function __construct(PostUserService $postUserService)
    {
        $this->postUserService = $postUserService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function paginate(Request $request)
    {
        return $this->postUserService->paginate($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \App\Traits\BusinessException
     */
    public function create(Request $request)
    {
        return $this->postUserService->create($request);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \App\Traits\BusinessException
     */
    public function update($id, Request $request)
    {
        return $this->postUserService->updateById($id, $request);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \App\Traits\BusinessException
     */
    public function delete($id, Request $request)
    {
        return $this->postUserService->deleteById($id, $request);
    }
}
