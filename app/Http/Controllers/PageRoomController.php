<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\User;
use App\Events\LeaveRoom;
use App\Events\KickUser;
use App\Events\SwitchTeam;


class PageRoomController extends Controller
{
    /**
     * Show room page
     */
    public function index($id)
    {
        $room = Room::findOrFail($id);
        return view('room', compact([
            'room',
        ]));
    }

    /**
     *
     */
    public function actionLeaveRoom(Request $request)
    {
        $user =  auth()->user();
        $room = Room::findOrFail($request->input('room_id'));
        $room->teamUsers()->where('user_id', $user->id)->delete();

        if ($room->admin_user_id === $user->id) {
            $room->switchAdmin();
        }

        event(new LeaveRoom($room));
    }

    /**
     *
     */
    public function actionSwitchTeam(Request $request)
    {
        $room = Room::findOrFail($request->input('room_id'));
        $teamUser = $room->teamUsers()->where('user_id', $request->input('user_id'))->first();
        $otherTeam = $room->teams()->where('id', '!=', $teamUser->team_id)->first();
        $teamUser->team_id = $otherTeam->id;
        $teamUser->save();
        event(new SwitchTeam($room));
    }

    /**
     *
     */
    public function actionKickUser(Request $request)
    {
        $room = Room::findOrFail($request->input('room_id'));
        $user = User::findOrFail($request->input('user_id'));
        $room->teamUsers()->where('user_id', $user->id)->delete();
        event(new KickUser($room, $user));
    }
}
