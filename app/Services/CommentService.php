<?php

namespace App\Services;

use App\Helpers\Constants;
use App\Helpers\DateTimeConverter;
use App\Models\Comment;
use App\Repositories\CommentRepository;
use App\Repositories\PostRepository;
use App\Traits\BaseResponse;
use App\Traits\BusinessException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CommentService implements BaseService
{
    use BaseResponse;

    public function __construct(
        CommentRepository $commentRepository,
        PostRepository $postRepository
    )
    {
        $this->commentRepository = $commentRepository;
        $this->postRepository = $postRepository;
    }

    public function all(Request $request)
    {
        return self::buildResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $this->commentRepository->all(['*'])
        );
    }

    public function paginate(Request $request)
    {
        // TODO: Implement paginate() method.
    }

    public function create(Request $request)
    {
        try {
            $record = new Comment();
            $record->post_id = $request->post_id;
            $record->description = $request->description;
            $record->created_at = DateTimeConverter::getDateTimeNow();
            $this->commentRepository->create($record->toArray());

        } catch (\Exception $ex) {
            Log::error(Constants::ERROR, ['message' => $ex->getMessage()]);
            throw new BusinessException(Constants::HTTP_CODE_500, Constants::ERROR_MESSAGE_9000, Constants::ERROR_CODE_9000);
        }

        return BaseResponse::statusResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
        );
    }

    public function deleteById($id, Request $request)
    {
        // TODO: Implement deleteById() method.
    }

    public function getById($id, Request $request)
    {
        // TODO: Implement getById() method.
    }

    public function updateById($id, Request $request)
    {
        // TODO: Implement updateById() method.
    }

    public function showCommentByPost($id)
    {
        $post = $this->postRepository->getById($id);
        $comment = Comment::where("post_id", '=', $post->id)->get();

        if (empty($comment)) {
            throw new BusinessException(Constants::HTTP_CODE_409, Constants::ERROR_MESSAGE_9001, Constants::ERROR_CODE_9001);
        }

        return BaseResponse::buildResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $comment
        );
    }
}
