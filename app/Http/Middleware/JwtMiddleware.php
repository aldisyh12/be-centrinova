<?php

namespace App\Http\Middleware;

use App\Helpers\Constants;
use App\Traits\BusinessException;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if ($user->email_verified_at) {
                throw new BusinessException(Constants::HTTP_CODE_409, 'Your Account not active', Constants::HTTP_CODE_409);
            }
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                throw new BusinessException(Constants::HTTP_CODE_403, 'Token is Invalid', Constants::HTTP_CODE_403);
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                throw new BusinessException(Constants::HTTP_CODE_403, 'Token is Expired', Constants::HTTP_CODE_401);
            } else {
                throw new BusinessException(Constants::HTTP_CODE_403, 'Authorization Token not found ', Constants::HTTP_CODE_403);
            }
        }
        return $next($request);
    }
}
