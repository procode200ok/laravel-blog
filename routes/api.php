<?php

use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PostTagController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostReportedController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\PostInteractionsController;
use App\Http\Controllers\UploadBlogContentController;

use App\Http\Controllers\Ai\OpenApi;
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
            Route::apiResource('post',             PostController::class);
            
            Route::apiResource('comment',          CommentsController::class);

            Route::apiResource('post-tags',        PostTagController::class);

            Route::apiResource('post-categories',  PostCategoryController::class);

            Route::apiResource('post-interactions',PostInteractionsController::class);
            
            Route::apiResource('report-post',      PostReportedController::class);

            Route::apiResource('upload-bolb',      UploadBlogContentController::class);

            Route::post('/test-open-ai-api', [OpenApi::class, 'getOpenAiData']);

            Route::get('/test-disk', [UploadBlogContentController::class, 'testDisk']);

            Route::post('/logout', [LoginController::class, 'logout']);
        });
    });
});