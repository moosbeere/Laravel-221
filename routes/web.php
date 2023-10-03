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
Route::get('/', function(){
    return redirect('/article');
});
Route::resource('article', ArticleController::class);

//Comments
Route::group(['prefix'=>'/comment'], function(){
    Route::post('/store', [CommentController::class, 'store']);
    Route::get('/edit/{id}', [CommentController::class, 'edit']);
    Route::post('/update/{id}', [CommentController::class, 'update']);
    Route::get('/delete/{id}', [CommentController::class, 'delete']);
});


//Auth
Route::get('/create', [AuthController::class, 'create']);
Route::post('/registr', [AuthController::class, 'registr']);

Route::get('/galery/{img}', function($img){
    return view('main.galery', ['img'=>$img]);
});

Route::get('/home', [MainController::class, 'index']);
Route::get('/contact', function(){
    $contacts = [
        'name'=>'Polytech',
        'address'=>'B.Semenovskay 38',
        'phone'=>'8(495)432-3232'
    ];
    return view('main.contact', ['contacts'=>$contacts]);
});
