<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamUser extends Pivot
{

    protected $table = 'team_users';

    public function team()
    {
        return $this->belongsTo(\App\Models\Team::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
