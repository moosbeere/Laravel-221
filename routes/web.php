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