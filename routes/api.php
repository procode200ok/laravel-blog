<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * Resgister and login route
 */

Route::post('/login',    [LoginController::class,    'login']);
Route::post('/register', [RegisterController::class, 'register']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

/**
 * user can create ,update and delete post
 */

Route::group(['middleware' => 'auth:user'], function () {
    Route::group(['prefix' => 'v1'], function () {
        Route::group(['prefix' => 'users'], function () {
            Route::apiResource('post', PostController::class);
            Route::apiResource('comment', CommentsController::class);
            Route::post('/logout', [LoginController::class, 'logout']);
        });
    });
});