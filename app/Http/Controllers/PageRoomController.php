<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class PageRoomController extends Controller
{
    /**
     * Show room page
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($id)
    {
        $room = Room::with([
                'words',
                'teams.users',
            ])->findOrFail($id);
        return view('room', compact([
            'room',
        ]));
    }
}
