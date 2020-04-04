<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

    protected $fillable = ['name'];

    public function room()
    {
        return $this->belongsTo(\App\Models\Room::class);
    }

    public function teamUsers()
    {
        return $this->hasMany(\App\Models\TeamUser::class);
    }

    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'team_users')
            ->using(\App\Models\TeamUser::class)
            ->withPivot([
                'score',
            ])
            ->as('team_user');
    }
}
