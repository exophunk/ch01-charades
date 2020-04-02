<?php

namespace App\Models;

use \App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

    protected $fillable = ['name'];

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

    public function hasUser(User $user) {
        return $this->teamUsers()->where('user_id', $user->id)->exists();
    }

    public function addUserToTeam(User $user) {
        $this->teams()
            ->withCount('teamUsers')
            ->orderBy('team_users_count', 'asc')
            ->first()
            ->users()->attach($user);
    }
}
