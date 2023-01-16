<?php

namespace App\Services;

use App\Helpers\Constants;
use App\Helpers\DateTimeConverter;
use App\Repositories\UsersRepository;
use App\Traits\BaseResponse;
use App\Traits\BusinessException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileUserService implements BaseService
{

    use BaseResponse;

    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }

    public function all(Request $request)
    {
        // TODO: Implement all() method.
    }

    public function paginate(Request $request)
    {
        // TODO: Implement paginate() method.
    }

    public function create(Request $request)
    {
        // TODO: Implement create() method.
    }

    public function deleteById($id, Request $request)
    {
        // TODO: Implement deleteById() method.
    }

    public function getById($id, Request $request)
    {
        $record = $this->usersRepository->getById($id);

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
        $record = $this->usersRepository->getById($id);

        try {
            $record->password = bcrypt($request->password);
            $record->updated_at = DateTimeConverter::getDateTimeNow();
            $this->usersRepository->updateById($id, $record->toArray());
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
