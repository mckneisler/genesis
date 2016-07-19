<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Artist extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

	public function albums()
	{
		return $this->hasMany('App\Album');
	}

	public function songs()
	{
		return $this->hasMany('App\Song');
	}

	public function users()
	{
		return $this->belongsToMany('App\User', 'artist_user_favorite');
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
