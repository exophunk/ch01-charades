<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/home', 'PageHomeController@index')->name('home');
    Route::post('/actions/home/create-room', 'PageHomeController@actionCreateRoom')->name('action-create-room');

    Route::middleware(['belongsToRoom'])->group(function () {
        Route::get('/room/{room_id}', 'PageRoomController@index')->name('room');
    });
});
