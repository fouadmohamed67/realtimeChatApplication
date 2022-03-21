<?php

use Illuminate\Support\Facades\Route;
use app\Http\Controllers;
 

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('message','App\Http\Controllers\messagesController');
Route::get('getChatOfToPersons','App\Http\Controllers\messagesController@getChatOfToPersons');
Route::get('online-user', [App\Http\Controllers\UserController::class, 'index']);
Route::get('make_user_online',[App\Http\Controllers\UserController::class, 'make_user_online']);
Route::get('update_real_time',[App\Http\Controllers\UserController::class, 'update_real_time'])->name('update_real_time');