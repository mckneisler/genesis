<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Song extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'album_id',
        'artist_id',
        'name'
    ];

	public function albums()
	{
		return $this->belongsTo('App\Album');
	}

	public function artists()
	{
		return $this->belongsTo('App\Artist');
	}

	public function users()
	{
		return $this->belongsToMany('App\User', 'song_user_favorite');
	}

	public function scopeFilter($query, QueryFilter $filters)
	{
		return $filters->apply($query);
	}

	public function scopeWithFavorites ($query)
	{
		if (Auth::check()) {
			return $query->withCount(['users' => function($query) {
				$query->where('id', Auth::user()->id);
			}]);
		}

		return $query;
	}
}
