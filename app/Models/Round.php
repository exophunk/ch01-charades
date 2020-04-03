<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Round extends Model
{

    protected $casts = [
        'round_start' => 'datetime',
        'round_end' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(\App\Models\Team::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function room()
    {
        return $this->belongsTo(\App\Models\Room::class);
    }
}
