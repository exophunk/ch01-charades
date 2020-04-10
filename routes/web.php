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


Route::get('/', 'PageHomeController@index')->name('home');
Route::get('/docs', 'PageHomeController@docs')->name('docs');
Route::get('/about', 'PageHomeController@about')->name('about');

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::post('/actions/home/create-room', 'PageHomeController@actionCreateRoom')->name('action-create-room');

    Route::middleware(['room.join'])->group(function () {
        Route::get('/room/{room_id}', 'PageRoomController@index')->name('room');
    });

    Route::middleware(['room.auth'])->group(function () {
        Route::post('/actions/room/leave-room', 'PageRoomController@actionLeaveRoom')->name('action-leave-room');
        Route::post('/actions/room/switch-team', 'PageRoomController@actionSwitchTeam')->name('action-switch-team');
        Route::post('/actions/game/create-word', 'GameController@actionCreateWord')->name('action-create-word');
        Route::post('/actions/game/start-round', 'GameController@actionStartRound')->name('action-start-round');
        Route::post('/actions/game/solve-word', 'GameController@actionSolveWord')->name('action-solve-word');

        Route::middleware(['room.auth.admin'])->group(function () {
            Route::post('/actions/game/start-game', 'GameController@actionStartGame')->name('action-start-game');
            Route::post('/actions/game/reset-cycle', 'GameController@actionResetCycle')->name('action-reset-cycle');
            Route::post('/actions/game/reset-game', 'GameController@actionResetGame')->name('action-reset-game');
            Route::post('/actions/game/clear-words', 'GameController@actionClearWords')->name('action-clear-words');
            Route::post('/actions/room/kick-user', 'PageRoomController@actionKickUser')->name('action-kick-user');
        });
    });

});
