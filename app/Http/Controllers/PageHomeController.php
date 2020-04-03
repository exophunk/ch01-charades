<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class PageHomeController extends Controller
{
    /**
     * Show home
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $rooms = Room::all();
        return view('home', compact([
            'rooms',
        ]));
    }


    /**
     *
     */
    public function actionCreateRoom(Request $request)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $room = Room::create($request->all());
        $room->teams()->createMany([
            [ 'name' => 'Team 1'],
            [ 'name' => 'Team 2'],
        ]);
        return redirect()->route('room', [ 'room_id' => $room->id]);
    }
}
