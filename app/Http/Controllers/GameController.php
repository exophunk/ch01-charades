<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Word;
use App\Models\Room;
use App\Models\Round;
use App\Events\CreateWord;
use App\Events\StartRound;
use App\Events\StartGame;
use App\Events\ResetGame;
use App\Events\ResetCycle;
use App\Events\ClearWords;
use App\Events\SolveWord;
use App\Events\EndCycle;



class GameController extends Controller
{
    /**
     *
     */
    public function actionCreateWord(Request $request)
    {
        $request->validate([
            'word' => [
                'required',
                'string',
                'max:255',
            ],
        ]);

        $word = new Word();
        $word->word = $request->input('word');
        $word->room_id = $request->input('room_id');
        $word->user_id = Auth::user()->id;
        $word->save();
        event(new CreateWord($word));
    }

    /**
     *
     */
    public function actionStartGame(Request $request)
    {
        $room = Room::findOrFail($request->input('room_id'));
        $room->cycle++;
        $room->save();
        event(new StartGame($room));
    }

    /**
     *
     */
    public function actionResetGame(Request $request)
    {
        $room = Room::findOrFail($request->input('room_id'));
        $room->reset();
        event(new ResetGame($room));
    }

    /**
     *
     */
    public function actionResetCycle(Request $request)
    {
        $room = Room::findOrFail($request->input('room_id'));
        $room->words()->update(['solved' => 0]);

        $rounds = $room->rounds()->where('cycle', $room->cycle);

        $rounds->each(function ($round) use ($room) {

            $team = $room->teams()->where('id', $round->team_id)->first();
            $teamUser = $room->teamUsers()->where('user_id', $round->user_id)->first();

            $team->score -= $round->score;
            $teamUser->score -= $round->score;

            $team->save();
            $teamUser->save();
        });

        $rounds->delete();
        event(new ResetCycle($room));
    }

    /**
     *
     */
    public function actionClearWords(Request $request)
    {
        $room = Room::findOrFail($request->input('room_id'));
        $room->words()->delete();
        event(new ClearWords($room));
    }

    /**
     *
     */
    public function actionStartRound(Request $request)
    {
        $room = Room::findOrFail($request->input('room_id'));
        $round = new Round();
        $round->room_id = $room->id;
        $round->team_id = $room->next_turn->team_id;
        $round->user_id = $room->next_turn->user_id;
        $round->cycle = $room->cycle;
        $round->round_start = Carbon::now();
        $round->round_end = Carbon::now()->addSeconds($room->round_duration);
        $round->save();
        event(new StartRound($round, $room->next_turn));
    }

    /**
     *
     */
    public function actionSolveWord(Request $request)
    {
        $user = auth()->user();

        $round = Round::findOrFail($request->input('round_id'));
        $word = Word::findOrFail($request->input('word_id'));
        $room = $round->room;

        if ($word->solved) {
            return;
        }

        $word->solved = true;
        $word->save();

        $round->score++;
        $round->save();

        $team = $user->getTeamOfRoom($room);
        $team->team_user->score++;
        $team->team_user->save();
        $team->score++;
        $team->save();

        $room->loadCount(['words' => function ($query) {
            $query->where('solved', false);
        }]);

        if ($room->words_count == 0) {
            $room->cycle++;
            $room->save();
            $room->words()->update(['solved' => false]);
            $latestRound = $room->rounds()->latest()->first();
            $latestRound->round_end = null;
            $latestRound->save();
            event(new EndCycle($room));
        } else {
            event(new SolveWord($room));
        }


    }
}
