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

    Route::middleware(['room.join'])->group(function () {
        Route::get('/room/{room_id}', 'PageRoomController@index')->name('room');
    });

    Route::middleware(['room.auth'])->group(function () {
        Route::post('/actions/game/create-word', 'GameController@actionCreateWord')->name('action-create-word');
        Route::post('/actions/game/start-cycle', 'GameController@actionStartCycle')->name('action-start-cycle');
        Route::post('/actions/game/reset-cycle', 'GameController@actionResetCycle')->name('action-reset-cycle');
        Route::post('/actions/game/start-round', 'GameController@actionStartRound')->name('action-start-round');
    });

});
