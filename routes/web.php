<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ArticleController;

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
//Comment
Route::prefix('/comment')->group(function(){
    Route::get('/create', [CommentController::class, 'create']);
    Route::post('/store', [CommentController::class, 'store']);
    Route::get('/edit/{id}', [CommentController::class, 'edit']);
    Route::post('/update/{id}', [CommentController::class, 'update']);
    Route::get('/delete/{id}', [CommentController::class, 'delete']);
});

//Article
Route::resource('article', ArticleController::class)->middleware('auth:sanctum');

//Auth
Route::post('/registr', [AuthController::class, 'registr']);
Route::get('/create', [AuthController::class, 'create']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/', [MainController::class, 'index']);
Route::get('/galery/{img}', [MainController::class, 'galery']);

// Route::get('/', function(){
//     return view('main.main');
// });

Route::get('/contact', function(){
    $data = [
        'name'=>'Moscow Polytech',
        'adres' => 'Bol. Semenovskaya',
        'phone'=>'8(495)223-2323',
        'email'=>'main@mospolytech.ru'
    ];
    return view('main.contacts', ['data'=>$data]);
});

// Route::get('/', function () {
//     return view('welcome');
// });
