<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

use App\Models\ModelWithLocales;
use App\Models\QueryFilter;
use App\Traits\StoreUserIdsSoftDelete;
use App\Exceptions\SystemErrorException;

class Code extends ModelWithLocales
{
    use SoftDeletes;
	use StoreUserIdsSoftDelete;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_code_id',
		'values_code_id',
        'code'
    ];

	public function users()
	{
		return $this->belongsToMany('App\Models\User', 'role_user', 'role_id', 'user_id');
	}

	public function values()
	{
		return $this->hasMany('App\Models\OptionUserValue', 'option_id');
	}

	public function parent()
	{
		return $this->belongsTo('App\Models\Code', 'parent_code_id');
	}

	public function children()
	{
		return $this->hasMany('App\Models\Code', 'parent_code_id');
	}

	public function childrenWithLocale()
	{
		return $this->hasMany('App\Models\Code', 'parent_code_id')
			->select(
				'codes.id',
				'codes.code',
				'codes.parent_code_id',
				'codes.values_code_id'
			)
			->withCount('children')
			->locale(['name']);
	}

	public function userValues()
	{
		return $this->hasMany('App\Models\OptionUserValue', 'option_id');
	}

	public function childrenWithLocaleWithUserValues()
	{

	}

	public function role_belongs_to_permissions()
	{
		return $this->belongsToMany('App\Models\Admin\Permission', 'permission_role', 'permission_id', 'role_id');
	}

	public function object_has_permissions()
	{
		return $this->hasMany('App\Models\Admin\Permission', 'object_id');
	}

	public function action_has_permissions()
	{
		return $this->hasMany('App\Models\Admin\Permission', 'action_id');
	}

	public function scopeFilter($query, QueryFilter $filters)
	{
		return $filters->apply($query);
	}

	public static function scopeLookup($query, $parent, $child = null)
	{
		if (is_numeric($parent)) {
			$parent_id = intval($parent);
		} else {
			$parent_id = self::getTypeId($parent);
		}

		if (strlen($child)) {
			if (is_string($child)) {
				return $query->where('parent_code_id', $parent_id)
					->where('code', $child)
					->withTrashed();
			} else {
				return $query->where('parent_code_id', $parent_id)
					->where('id', $child)
					->withTrashed();
			}
		} else {
			return $query->where('id', $parent_id)
				->withTrashed();
		}
	}

	public function scopeOfType($query, $type)
	{
		if (is_string($type)) {
			return $query->where('parent_code_id', $this->getTypeId($type));
		} else {
			return $query->where('parent_code_id', $type);
		}
	}

	public function scopeWithUserValues($query, $user_id)
	{
		$query->addSelect(DB::Raw('IFNULL(user.value_id, system.value_id) as value_id'));
		$query->addSelect(DB::Raw('IFNULL(user.created_at, system.created_at) as created_at'));
		$query->addSelect(DB::Raw('IFNULL(user.updated_at, system.updated_at) as updated_at'));
		$query->addSelect(DB::Raw('IFNULL(user.created_by, system.created_by) as created_by'));
		$query->addSelect(DB::Raw('IFNULL(user.updated_by, system.updated_by) as updated_by'));

		// Join to the option_user_values table with the system user id
		$query->leftJoin('option_user_values as system', function($join) {
			$join->on('codes.id', '=', 'system.option_id')->where('system.user_id', '=', 1);
		});

		// Join to the option_user_values table with the requested user id
		$query->leftJoin('option_user_values as user', function($join) use ($user_id) {
			$join->on('codes.id', '=', 'user.option_id')->where('user.user_id', '=', $user_id);
		});

		return $query;
	}

	public function scopeListTypes($query)
	{
		return $query->where('parent_code_id', 1);
	}

	public static function closureWithUserValues($user_id)
	{
		return function ($query) use ($user_id) {
			$query->withUserValues($user_id)
				->orderBy('children_count')
				->orderBy(DB::Raw('IFNULL(IFNULL(loc.name, def.name), codes.code)'));
		};
	}

	public static function typeArray($type)
	{
		return self::select('id')
			->ofType($type)
			->locale(['name'])
			->orderBy('name')
			->lists('name', 'id')
			->toArray();
	}

	public static function typeArrayWithDescriptions($type)
	{
		$records = self::select('id')
			->ofType($type)
			->locale(['name', 'description'])
			->orderBy('name')
			->get();
		foreach ($records as $record) {
			$array[$record->id] = [
				'name' => $record->name,
				'description' => $record->description
			];
		}
		return $array;
	}

	public static function getCode($id = null, $locale = null)
	{
		if (is_numeric($id)) {
			$type = intval($id);
			$item = null;
		} else {
			$segments = explode('.', $id);
			$type_path = $segments[0];
			list($parent, $type) = self::getParentFromPath($type_path);
			if (isset($type->id)) {
				$type = $type->id;
				if (count($segments) == 1) {
					$item = null;
				} else {
					$item = implode('.', array_slice($segments, 1));
				}
			}
		}

		if (is_null($type)) {
			$code = null;
		} else {
			$code = self::select(['id', 'code'])->lookup($type, $item)->locale(['name', 'description'], $locale)->first();
		}

		if (is_null($code)) {
			$code = [
				'name' => $id,
				'description' => $id
			];
		}

		return $code;
	}

	public static function getParentFromPath($type_path)
	{
		$types = explode(':', $type_path);
		$types = array_prepend($types, 'types');
		for ($i=0; $i<count($types);  $i++) {
			$query = self::select(['id', 'code'])
				->where('code', $types[$i])
				->locale(['name', 'description'])
				->withTrashed();
			if (isset($code)) {
				$query->where('parent_code_id', $code->id);
			} else {
				$query->where('parent_code_id', 1);
			}
			$code = $query->first();
			if ($i == count($types) - 1) {
				$type = $code;
			} else {
				$parent = $code;
			}
		}

		return [$parent, $type];
	}

	public static function getParentFromPathNoLocale($type_path)
	{
		$types = explode(':', $type_path);
		$types = array_prepend($types, 'types');
		for ($i=0; $i<count($types);  $i++) {
			$query = self::select(['id', 'code'])
				->where('code', $types[$i])
				->withTrashed();
			if (isset($code)) {
				$query->where('parent_code_id', $code->id);
			} else {
				$query->where('parent_code_id', 1);
			}
			$code = $query->first();
			if ($i == count($types) - 1) {
				$type = $code;
			} else {
				$parent = $code;
			}
		}

		return [$parent, $type];
	}

	public static function getPathFromId($id, $field = 'code', $delimeter = ':')
	{
		$paths = [];
		$code = self::select('parent_code_id', 'id', 'code')
			->lookup($id)
			->locale(['name'])
			->first();

		if ($code->id == $code->parent_code_id) {
			$paths[] = choose($code->{$field}, 2);
		} else {
			while ($code->id != $code->parent_code_id) {
				$paths = array_prepend($paths, choose($code->{$field}, 2));
				$code = self::select('parent_code_id', 'id', 'code')
					->lookup($code->parent_code_id)
					->locale(['name'])
					->withTrashed()
					->first();
			}
		}

		return implode($delimeter, $paths);
	}

	public static function getTypeId($code)
	{
		list($parent_type, $type) = self::getParentFromPathNoLocale($code);

		return $type ? $type->id : $type;
	}

	public static function getCodeId($type, $code)
	{
		$model = self::lookup($type, $code)
			->withTrashed()
			->first();
		if ($model) {
			return $model->id;
		} else {
			return $model;
		}
	}
}
