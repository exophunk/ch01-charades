<?php

namespace App\Http\Middleware;

use Closure;
use \App\Models\Room;
use App\Events\JoinRoom as JoinRoomEvent;

class JoinRoom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $room = Room::findOrFail($request->room_id);
        if (!$room->hasUser($request->user())) {
            $room->addUserToTeam($request->user());
            event(new JoinRoomEvent($room));
        }
        return $next($request);
    }
}
