<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class PageHomeController extends Controller
{
    /**
     * Show home
     *
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
    public function docs()
    {
        return view('docs');
    }

    /**
     *
     */
    public function about()
    {
        return view('about');
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
        $room->admin()->associate(auth()->user());
        $room->teams()->createMany([
            [ 'name' => 'Team 1'],
            [ 'name' => 'Team 2'],
        ]);
        $room->save();
        return redirect()->route('room', [ 'room_id' => $room->id]);
    }
}
