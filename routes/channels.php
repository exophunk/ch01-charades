<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Room;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('room.{room}', function (User $user, Room $room) {
    return $room->hasUser($user);
});
