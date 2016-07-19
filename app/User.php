<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
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

	public function albums()
	{
		return $this->belongsToMany('App\Album', 'album_user_favorite');
	}

	public function artists()
	{
		return $this->belongsToMany('App\Artist', 'artist_user_favorite');
	}

	public function songs()
	{
		return $this->belongsToMany('App\Song', 'song_user_favorite');
	}
}
