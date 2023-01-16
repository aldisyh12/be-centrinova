<?php

namespace App\Services;

use App\Helpers\Base64Converter;
use App\Helpers\Constants;
use App\Helpers\DateTimeConverter;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Traits\BaseResponse;
use App\Traits\BusinessException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PostUserService implements BaseService
{
    use BaseResponse;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function all(Request $request)
    {
        // TODO: Implement all() method.
    }

    public function paginate(Request $request)
    {
        return self::buildResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $this->postRepository->paginate($request->searchBy, $request->searchParam, $request->limit, ['*'], 'page', $request->page)
        );
    }

    public function create(Request $request)
    {
        try {
//            if ($request->hasFile('images')) {
//                $file = $request->file('images');
//                $filename = "post-" . time() . '.' . $file->getClientOriginalExtension();
//                $imagePath = '/public/upload/images';
//                $file->move(public_path($imagePath), $filename);

                $record = new Post();
                $record->judul = $request->judul;
                $record->categories = $request->categories;
                $record->images = Base64Converter::base64ToImage("blogs", $request->images);;
                $record->description = $request->description;
                $record->created_at = DateTimeConverter::getDateTimeNow();
                $this->postRepository->create($record->toArray());
//            }

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
        $record = $this->postRepository->getById($id);
        if (empty($record)) {
            throw new BusinessException(Constants::HTTP_CODE_409, Constants::ERROR_MESSAGE_9001, Constants::ERROR_CODE_9001);
        }

        try {
            $record->forceDelete();
        } catch (\Exception $ex) {
            Log::error(Constants::ERROR, ['message' => $ex->getMessage()]);
            throw new BusinessException(Constants::HTTP_CODE_500, Constants::ERROR_MESSAGE_9000, Constants::ERROR_CODE_9000);
        }

        return BaseResponse::statusResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200
        );
    }

    public function getById($id, Request $request)
    {
        $record = $this->postRepository->getById($id);

        if (empty($record)) {
            throw new BusinessException(Constants::HTTP_CODE_409, Constants::ERROR_MESSAGE_9001, Constants::ERROR_CODE_9001);
        }

        return BaseResponse::buildResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $record
        );
    }

    public function updateById($id, Request $request)
    {
        $record = $this->postRepository->getById($id);

        try {
            if ($request->hasFile('images')) {
                $file = $request->file('images');
                $filename = "post-" . time() . '.' . $file->getClientOriginalExtension();
                $imagePath = '/public/upload/images';
                $file->move(public_path($imagePath), $filename);

                $record->judul = $request->judul;
                $record->categories = $request->categories;
                $record->images = $filename;
                $record->description = $request->description;
                $record->updated_at = DateTimeConverter::getDateTimeNow();
                $this->postRepository->updateById($id, $record->toArray());
            }
        } catch (\Exception $ex) {
            Log::error(Constants::ERROR, ['message' => $ex->getMessage()]);
            throw new BusinessException(Constants::HTTP_CODE_500, Constants::ERROR_MESSAGE_9000, Constants::ERROR_CODE_9000);
        }

        return BaseResponse::statusResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
        );
    }
}
