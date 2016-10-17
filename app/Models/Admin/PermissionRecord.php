<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Helpers\Locales;
use App\Models\QueryFilter;

use App\Models\Code;

class PermissionRecord extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'permission_id',
        'record_id'
    ];

	public function roles()
	{
		return $this->belongsToMany('App\Models\Code', 'permission_record_role', 'permission_record_id', 'role_id');
	}

	public function rolesWithLocale()
	{
		return $this->belongsToMany('App\Models\Code', 'permission_record_role', 'permission_record_id', 'role_id')
			->select('codes.id')
			->locale(['name'])
			->orderBy('name');
	}

    public function scopeLookup($query, $object, $action, $id)
	{
		$permission = Permission::select(['permissions.id'])->locale(['code'])->lookup($object, $action)->first();
		if (is_string($id)) {
			if ($object != 'codes' && Schema::hasTable($object)) {
				$record_id = DB::table($object)->where('code', $id)->first()->id;
			} else {
				$record_id = Code::getCodeId('types', $id);
			}
		} else {
			$record_id = $id;
		}
		return $query->where('permission_id', $permission->id)->where('record_id', $record_id);
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

		$query = Locales::addScope($query, $table, 'record_id', $localeTable, $localeParentId, $requestedColumns, $locale, 'record', $parentId);

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
}
