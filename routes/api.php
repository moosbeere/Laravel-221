<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CommentController;

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

//Article
Route::resource('/article', ArticleController::class)->middleware('auth:sanctum');
Route::get('/article', [ArticleController::class, 'index']);
Route::get('/article/{article}', [ArticleController::class, 'show'])->name('article.show')->middleware('path');

//Comment
Route::group(['prefix' => '/comment', 'middleware'=>'auth:sanctum'], function(){
    Route::post('/store', [CommentController::class, 'store']);
    Route::get('/edit/{id}', [CommentController::class, 'edit']);
    Route::post('/update/{id}', [CommentController::class, 'update']);
    Route::get('/delete/{id}', [CommentController::class, 'delete']);
    Route::get('', [CommentController::class, 'index'])->name('comments');
    Route::get('accept/{id}', [CommentController::class, 'accept']);
    Route::get('reject/{id}', [CommentController::class, 'reject']);
});

//Auth
Route::get('/create', [AuthController::class, 'create']);
Route::post('/registr', [AuthController::class, 'registr']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'customLogin']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
