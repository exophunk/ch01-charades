<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function words()
    {
        return $this->hasMany(\App\Models\Word::class);
    }

    public function teams()
    {
        return $this->belongsToMany(\App\Models\Team::class, 'team_users')
            ->using(\App\Models\TeamUser::class)
            ->withPivot([
                'score',
            ]);
    }

    public function rooms()
    {
        return $this->hasManyThrough(\App\Models\Room::class, \App\Models\Team::class);
    }
}
