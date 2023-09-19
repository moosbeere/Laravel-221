<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\AuthController;

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

//Auth
Route::get('/create', [AuthController::class, 'create']);
Route::post('/registr', [AuthController::class, 'registr']);


Route::get('/', [MainController::class, 'index']);

Route::get('/galery/{img}', function($img){
    return view('main.galery', ['img'=>$img]);
});

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
