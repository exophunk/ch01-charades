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
}
