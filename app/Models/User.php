<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Traits\StoreUserIdsSoftDelete;

class User extends Authenticatable
{
    use SoftDeletes;
	use StoreUserIdsSoftDelete;

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

    public static function find($id, $columns = ['*'])
    {
        return parent::withTrashed()->find($id, $columns);
    }

	public function albums()
	{
		return $this->belongsToMany('App\Models\Music\Album', 'album_user_favorite');
	}

	public function artists()
	{
		return $this->belongsToMany('App\Models\Music\Artist', 'artist_user_favorite');
	}

	public function songs()
	{
		return $this->belongsToMany('App\Models\Music\Song', 'song_user_favorite');
	}

	public function roles()
	{
		return $this->belongsToMany('App\Models\Code', 'role_user', 'user_id', 'role_id');
	}

	public function rolesWithLocale()
	{
		return $this->belongsToMany('App\Models\Code', 'role_user', 'user_id', 'role_id')
			->locale(['name']);
	}

	public function scopeFilter($query, QueryFilter $filters)
	{
		return $filters->apply($query);
	}

	public function hasRole($role)
	{
		if (is_string($role)) {
			return $this->roles->contains('code', $role);
		}
		return !! $role->intersect($this->roles)->count();
	}

	public function getById ($id)
	{
		return User::find($id);
	}

	/**
	 * Get a list of roles
	 *
	 * @return array
	 */
	public function getRoleListAttribute()
	{
		return $this->roles->lists('id')->toArray();
	}
}
