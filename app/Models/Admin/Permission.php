<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use App\Helpers\Locales;
use App\Models\Code;
use App\Models\QueryFilter;
use App\Traits\StoreUserIds;

class Permission extends Model
{
	use StoreUserIds;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'object_id',
        'action_id'
    ];

	public function object()
	{
		return $this->belongsTo('App\Models\Code', 'object_id');
	}

	public function action()
	{
		return $this->belongsTo('App\Models\Code', 'action_id');
	}

	public function roles()
	{
		return $this->belongsToMany('App\Models\Code', 'permission_role', 'permission_id', 'role_id');
	}

	public function rolesWithLocale()
	{
		return $this->belongsToMany('App\Models\Code', 'permission_role', 'permission_id', 'role_id')
			->select('codes.id')
			->locale(['name'])
			->orderBy('name');
	}

	public function records()
	{
		return $this->hasMany('App\Models\Admin\PermissionRecord', 'permission_id', 'id');
	}

	public function recordsWithLocale()
	{
		return $this->hasMany('App\Models\Admin\PermissionRecord', 'permission_id', 'id')
			->addSelect('permission_records.id')
			->locale(['code', 'name']);
	}

	public function scopeLookup($query, $object, $action)
	{
		return $query->where('object.code', $object)->where('action.code', $action);
	}

	/**
	 * Scope to return the locale values
	 *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  array   $requestedColumns
     * @param  string  $relationship
     * @param  string  $locale
     * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function scopeLocale($query, array $requestedColumns = [], $locale = null)
	{
		// Get the locale table name
		$table = $this->getTable();
		$localeParentId = 'model_id';
		$parentId = 'id';
		$localeTable = 'code_locales';

		$query = Locales::addScope($query, $table, 'object_id', $localeTable, $localeParentId, $requestedColumns, $locale, 'object', $parentId);
		$query = Locales::addScope($query, $table, 'action_id', $localeTable, $localeParentId, $requestedColumns, $locale, 'action', $parentId);

		return $query;
	}

	public function scopeFilter($query, QueryFilter $filters)
	{
		return $filters->apply($query);
	}

	/**
	 * Get a list of roles
	 *
	 * @return array
	 */
	public function getRoleListAttribute()
	{
		return $this->rolesWithLocale->lists('id')->toArray();
	}

	public function getRecords()
	{
		$type = isTableOrCode($this->object_code);

		if ($this->object_code == 'codes') {
			$type = 'code';
			$name = 'types';
		} else {
			$name = $this->object_code;
		}

		switch ($type) {
			case 'table':
				if (Schema::hasColumn($name, 'name')) {
					$records = DB::table($name)
						->orderBy('name')
						->lists('name', 'id');
				} else {
					switch ($name) {
						case 'permissions':
							$permissions = Permission::select('permissions.id')
								->locale(['code', 'name'])
								->orderBy('object_name')
								->orderBy('action_name')
								->get();
							$records = [];
							foreach ($permissions as $permission) {
								$records[$permission->id] = choose($permission->object_name, 1) . '-' . $permission->action_name;
							}
							break;
					}

				}
				break;
			case 'code':
				$records = Code::select('id')
					->ofType($name)
					->locale(['name'])
					->orderBy('name')
					->lists('name', 'id')
					->toArray();
				break;
		}

		return $records;
	}
}
