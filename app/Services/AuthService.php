<?php

namespace App\Services;

use App\Helpers\CommonUtil;
use App\Helpers\Constants;
use App\Models\User;
use App\Repositories\UsersRepository;
use App\Traits\BaseResponse;
use App\Traits\BusinessException;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class AuthService
{
    use BaseResponse;

    protected $jwt;

    public function __construct(
        JWTAuth $jwt,
        UsersRepository $usersRepository
    )
    {
        $this->jwt = $jwt;
        $this->userRepository = $usersRepository;
    }

    public function register(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        event(new Registered($user));

        return self::statusResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            CommonUtil::generateUUID()
        );
    }

    public function login(Request $request)
    {
        $credential = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $ttl = env('JWT_TTL', 1440);
        if ($request->remember_me) {
            $ttl = env('JWT_REMEMBER_TTL', 1051200);
        }

        if (!$token = auth()->setTTL($ttl)->attempt($credential)) {
            throw new BusinessException(Constants::HTTP_CODE_409, 'Invalid username or password!', Constants::ERROR_CODE_9000);
        }

        return self::buildResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $this->generateToken($token),
            CommonUtil::generateUUID()
        );
    }

    public function logout()
    {
        auth()->logout();
        auth()->invalidate(true);
        return BaseResponse::statusResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200
        );
    }

    public function refreshToken(Request $request)
    {
        return BaseResponse::buildResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200,
            $this->generateToken(auth()->refresh())
        );
    }

    protected function generateToken($token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }

    public function destroy($id, Request $request)
    {

        $token = auth()->tokenById($id);
        if (!isset($token)) {
            throw new BusinessException(Constants::HTTP_CODE_403, 'Invalid Authorization', Constants::HTTP_CODE_403);
        }

        $this->jwt->setToken($token)->invalidate(true);
        return BaseResponse::statusResponse(
            Constants::HTTP_CODE_200,
            Constants::HTTP_MESSAGE_200
        );
    }
}
