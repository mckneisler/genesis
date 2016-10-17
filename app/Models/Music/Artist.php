<?php

namespace App\Models\Music;

use Illuminate\Database\Eloquent\Model;
use Auth;

use App\Models\QueryFilter;
use App\Traits\StoreUserIds;

class Artist extends Model
{
	use StoreUserIds;

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
		return $this->hasMany('App\Models\Music\Album');
	}

	public function songs()
	{
		return $this->hasMany('App\Models\Music\Song');
	}

	public function users()
	{
		return $this->belongsToMany('App\Models\User', 'artist_user_favorite');
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
