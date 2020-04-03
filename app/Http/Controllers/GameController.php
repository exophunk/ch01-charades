<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Word;
use App\Models\Room;
use App\Models\Round;

use App\Http\Requests\CreateWordRequest;

class GameController extends Controller
{
    /**
     *
     */
    public function actionCreateWord(CreateWordRequest $request)
    {
        $word = new Word();
        $word->word = $request->input('word');
        $word->room_id = $request->input('room_id');
        $word->user_id = Auth::user()->id;
        $word->save();
    }

    /**
     *
     */
    public function actionGoToNextCycle(Request $request)
    {
        $room = Room::findOrFail($request->input('room_id'));
        $room->cycle++;
        $room->save();
    }

    /**
     *
     */
    public function actionStartRound(Request $request)
    {

        $room = Room::findOrFail($request->input('room_id'));

     */
    public function actionStartRound(Request $request)
    {
        $room = Room::findOrFail($request->input('room_id'));

        // SELECT team_users.team_id, team_users.user_id, round_start, MAX(round_start) as last_played FROM team_users
        // LEFT JOIN rounds
        // ON team_users.user_id = rounds.user_id AND rounds.room_id = 1
        // WHERE team_users.team_id IN (SELECT id from teams WHERE room_id = 1)
        // AND
        // (team_users.team_id !=
        //     (SELECT team_id
        //     FROM rounds
        //     WHERE room_id = 1
        //     ORDER BY round_start DESC
        //     LIMIT 1)
        // OR (SELECT count(*) FROM rounds r WHERE r.room_id = 1 ) = 0)
        // GROUP BY team_users.team_id, team_users.user_id
        // ORDER BY last_played, team_users.team_id, team_users.id
		// LIMIT 1;

        $result = DB::table('team_users')->select('team_users.team_id', 'team_users.user_id', DB::raw('MAX(round_start) as last_played'))
            ->leftJoin('rounds', function ($join) use ($room) {
                $join->on('team_users.user_id', '=', 'rounds.user_id')
                     ->where('rounds.room_id', '=', $room->id);
            })
            ->whereRaw('team_users.team_id IN (SELECT id from teams WHERE room_id = ?)', [$room->id])
            ->where(function ($query) use ($room) {
                $query
                    ->whereRaw('team_users.team_id != (SELECT team_id FROM rounds WHERE room_id = ? ORDER BY round_start DESC LIMIT 1)', [$room->id])
                    ->orWhere(function ($query) use ($room) {
                        $query
                            ->select(DB::raw('count(*)'))
                            ->from('rounds as r')
                            ->where('r.room_id', $room->id);
                    }, 0);
            })
            ->groupBy('team_users.team_id')
            ->groupBy('team_users.user_id')
            ->orderBy('last_played')
            ->orderBy('team_users.team_id')
            ->orderBy('team_users.id')
            ->first();

        // TODO
        if (!$result) {
            return abort(500);
        }

        $round = new Round();
        $round->room_id = $room->id;
        $round->team_id = $result->team_id;
        $round->user_id = $result->user_id;
        $round->round_start = Carbon::now();
        $round->round_end = Carbon::now()->addSeconds($room->round_duration);
        $round->save();
        event(new StartRound($round));
    }
}
