<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Article
Route::resource('/article', ArticleController::class);

//Comment
Route::group(['prefix' => '/comment'], function(){
    Route::post('/store', [CommentController::class, 'store'])->middleware('auth:sanctum');
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
Route::get('/logout', [AuthController::class, 'logout']);




// Route::get('/', function () {
//     return view('main.main');
// });

Route::get('/', [MainController::class, 'index']);
Route::get('galery/{img}', [MainController::class, 'show']);

Route::get('contacts', function(){
    $contact = [
        'name'=>'Polytech',
        'adress' => 'B.Semenovskaya 38',
        'phone' => '8(495)232-3232'
    ];
    return view('main.contact', ['data' => $contact]);
});