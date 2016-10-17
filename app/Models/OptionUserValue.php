<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\StoreUserIds;

class OptionUserValue extends Model
{
	use StoreUserIds;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'option_id',
        'user_id',
        'value_id'
    ];

	public function option()
	{
		return $this->belongsTo('App\Models\Code', 'option_id');
	}

	public function user()
	{
		return $this->belongsTo('App\Models\User');
	}

	public function value()
	{
		return $this->belongsTo('App\Models\Code', 'value_id');
	}

	public static function userOption($user_id, $option_id)
	{
		return self::where('user_id', $user_id)
			->where('option_id', $option_id)
			->first();
	}

	public function scopeForUser($query, $user_id)
	{
		return $query->where('user_id', $user_id);
	}

	public static function closureForUser($user_id)
	{
		return function ($query) use ($user_id) {
			$query->where('user_id', $user_id);
		};
	}
}
