<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;

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
