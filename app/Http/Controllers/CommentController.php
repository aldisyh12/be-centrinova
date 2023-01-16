<?php

namespace App\Http\Controllers;

use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function all(Request $request)
    {
        return $this->commentService->all($request);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     * @throws \App\Traits\BusinessException
     */
    public function create(Request $request)
    {
        return $this->commentService->create($request);
    }

    public function showCommentByPost($id)
    {
        return $this->commentService->showCommentByPost($id);
    }
}
