<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function words()
    {
        return $this->hasMany(\App\Models\Word::class);
    }

    public function teams()
    {
        return $this->hasMany(\App\Models\Team::class);
    }

    public function users()
    {
        return $this->hasManyThrough(\App\Models\User::class, \App\Models\Team::class);
    }
}
