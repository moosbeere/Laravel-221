<?php

use Illuminate\Support\Facades\Route;
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

Route::get('/', [ArticleController::class, 'index']);

Route::get('/home', function () {
    return view('main.main');
});

Route::get('/contact', function(){
    $contacts = [
        'name'=>'Polytech',
        'address'=>'B.Semenovskay 38',
        'phone'=>'8(495)432-3232'
    ];
    return view('main.contact', ['contacts'=>$contacts]);
});
