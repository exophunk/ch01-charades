<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use \App\Models\User;

class Room extends Model
{

    protected $fillable = ['name'];
    protected $appends = ['next_turn'];
    protected $with = ['rounds', 'words', 'teams'];

    public function rounds()
    {
        return $this->hasMany(\App\Models\Round::class)->orderBy('round_start', 'desc');
    }

    public function words()
    {
        return $this->hasMany(\App\Models\Word::class);
    }

    public function teams()
    {
        return $this->hasMany(\App\Models\Team::class);
    }

    public function teamUsers()
    {
        return $this->hasManyThrough(\App\Models\TeamUser::class, \App\Models\Team::class);
    }

    public function admin()
    {
        return $this->belongsTo(\App\Models\User::class, 'admin_user_id');
    }

    public function hasUser(User $user)
    {
        return $this->teamUsers()->where('user_id', $user->id)->exists();
    }

    public function addUserToTeam(User $user)
    {
        $this->teams()
            ->withCount('teamUsers')
            ->orderBy('team_users_count', 'asc')
            ->first()
            ->users()->attach($user);
    }

    public function switchAdmin()
    {
        $this->admin_user_id = $this->teamUsers[0] ? $this->teamUsers[0]->user_id : null;
        $this->save();
    }


    public function reset()
    {
        $this->rounds()->delete();
        $this->teams()->update(['score' => 0]);
        $this->words()->update(['solved' => 0]);
        $this->cycle = 0;
        $this->save();

        TeamUser::whereIn('team_id', $this->teams->pluck('id'))->update(['score' => 0]);
    }

    public function getNextTurnAttribute()
    {
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

        return DB::table('team_users')->select('team_users.team_id', 'team_users.user_id', DB::raw('MAX(round_start) as last_played'))
            ->leftJoin('rounds', function ($join) {
                $join->on('team_users.user_id', '=', 'rounds.user_id')
                     ->where('rounds.room_id', '=', $this->id);
            })
            ->whereRaw('team_users.team_id IN (SELECT id from teams WHERE room_id = ?)', [$this->id])
            ->where(function ($query) {
                $query
                    ->whereRaw('team_users.team_id != (SELECT team_id FROM rounds WHERE room_id = ? ORDER BY round_start DESC LIMIT 1)', [$this->id])
                    ->orWhere(function ($query) {
                        $query
                            ->select(DB::raw('count(*)'))
                            ->from('rounds as r')
                            ->where('r.room_id', $this->id);
                    }, 0);
            })
            ->groupBy('team_users.team_id')
            ->groupBy('team_users.user_id')
            ->orderBy('last_played')
            ->orderBy('team_users.team_id')
            ->orderBy('team_users.id')
            ->first();
    }
}
