<?php

namespace App\Http\Controllers;

use App\Services\PostService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function all(Request $request)
    {
        return $this->postService->all($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function paginate(Request $request)
    {
        return $this->postService->paginate($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \App\Traits\BusinessException
     */
    public function create(Request $request)
    {
        return $this->postService->create($request);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \App\Traits\BusinessException
     */
    public function update($id, Request $request)
    {
        return $this->postService->updateById($id, $request);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \App\Traits\BusinessException
     */
    public function show($id, Request $request)
    {
        return $this->postService->getById($id, $request);
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \App\Traits\BusinessException
     */
    public function delete($id, Request $request)
    {
        return $this->postService->deleteById($id, $request);
    }
}
