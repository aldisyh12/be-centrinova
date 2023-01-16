<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostUserController;
use App\Http\Controllers\ProfileUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** Public Route */

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/password/forgot', [AuthController::class, 'login']);
    Route::post('/password/validate', [AuthController::class, 'login']);
    Route::post('/password/reset', [AuthController::class, 'login']);
    Route::delete('/destroy/{id}', [AuthController::class, 'destroy']);
});

Route::group(['prefix' => 'post'], function () {
    Route::get('/all', [PostController::class, 'all']);
    Route::get('/paginate', [PostController::class, 'paginate']);
    Route::post('/create', [PostController::class, 'create']);
    Route::post('/update/{id}', [PostController::class, 'update']);
    Route::get('/show/{id}', [PostController::class, 'show']);
    Route::delete('/delete/{id}', [PostController::class, 'delete']);
});


Route::group(['prefix' => 'comment'], function () {
    Route::get('/all', [CommentController::class, 'all']);
    Route::post('/create', [CommentController::class, 'create']);
    Route::get('/showCommentByPost/{id}', [CommentController::class, 'showCommentByPost']);
});

/** Protected Route */

Route::group(['middleware' => ['jwt.verify']], function () {
    /** Butuh Token Login */
    Route::group(['prefix' => 'user'], function () {

        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/update/profile/{id}', [ProfileUserController::class, 'update']);
        Route::get('/show/profile/{id}', [ProfileUserController::class, 'show']);

        Route::group(['prefix' => 'post'], function () {
            Route::get('/paginate', [PostUserController::class, 'paginate']);
            Route::post('/create', [PostUserController::class, 'create']);
            Route::get('/show/{id}', [PostUserController::class, 'show']);
            Route::post('/update/{id}', [PostUserController::class, 'update']);
            Route::delete('/delete/{id}', [PostUserController::class, 'delete']);
        });
    });
});
