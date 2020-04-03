<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class PageRoomController extends Controller
{
    /**
     * Show room page
     */
    public function index($id)
    {
        $room = Room::with([
                'words',
                'rounds',
                'teams.users',
            ])->findOrFail($id);
        return view('room', compact([
            'room',
        ]));
    }
}
