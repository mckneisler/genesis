<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use App\Http\Controllers\Controller;
use App\Helpers\Locales;
use App\Models\Code;
use App\Models\Admin\Permission;
use App\Models\Admin\PermissionRecord;
use App\Models\Admin\PermissionRecordFilters;
use App\Http\Requests;
use App\Http\Requests\Admin\PermissionRecordRequest;

class PermissionRecordsController extends Controller
{
	public function __construct()
	{
        $this->middleware('maint');
		$this->middleware('auth');

		$this->middleware('permission:permissions-list')->only('index');
		$this->middleware('permission:permissions-add')->only('create', 'store');
		$this->middleware('permission:permissions-edit|permissions-edit_roles')->only('edit', 'update');
	}

    public function index(Permission $permission, PermissionRecordFilters $filters)
	{
		/*
		 * Default filters
		 */
		if ( ! request()->has('sort')) {
			request()->request->add(['sort' => 'record']);
			request()->request->add(['order' => 'asc']);
		}
		session()->put('url.back', request()->fullUrl());

		$name = $permission->object_code;
		if ($name == 'codes') {
			$type = 'code';
		} else {
			$type = isTableOrCode($name);
		}

		switch ($type) {
			case 'table':
				$query = PermissionRecord::select(
						'permission_records.id'
					)
					->join($name . ' as records', 'record_id', '=', 'records.id')
					->with('rolesWithLocale')
					->where('permission_id', $permission->id)
					->filter($filters);
				if (Schema::hasColumn($name, 'name')) {
					$query->addSelect(DB::Raw('records.name as record_name'));
				} else {
					switch ($name) {
						case 'permissions':
							$table = $name;
							$localeParentId = 'model_id';
							$parentId = 'id';
							$localeTable = 'code_locales';
							$requestedColumns = ['name'];

							$query = Locales::addScope($query, $table, 'object_id', $localeTable, $localeParentId, $requestedColumns, null, 'object', $parentId);
							$query = Locales::addScope($query, $table, 'action_id', $localeTable, $localeParentId, $requestedColumns, null, 'action', $parentId);
							break;
					}

				}
				break;
			case 'code':
				$query =  $permission->recordsWithLocale()
					->with('rolesWithLocale')
					->filter($filters);
				break;
		}
		$sql = $query->toSql();
//echo '<div id="sqlret">' . format($sql) . '</div>';
		$records =  $query
			->get();
		switch ($name) {
			case 'permissions':
				$records = $records->each(function($item, $key) {
					$item->record_name = choose($item->object_name, 1) . '-' . $item->action_name;
				});
				break;
		}

		$roles = Code::select('code')
			->ofType('roles')
			->locale(['name'])
			->orderBy('name')
			->lists('name', 'code')
			->toArray();
		$defaults = [];

		return view('admin.permissions.records.index', compact(
			'permission',
			'records',
			'roles',
			'defaults'
		));
	}

    public function create(Permission $permission)
	{
		$records = $permission->getRecords();

		$roles = Code::typeArray('roles');
		return view('admin.permissions.records.create', compact(
			'permission',
			'records',
			'roles'
		));
	}

	public function store(PermissionRecordRequest $request)
	{
		$permission = Permission::where('permissions.id', $request->permission_id)
			->select('permissions.id')
			->locale(['code'])
			->first();

		$permission_record = PermissionRecord::create($request->all());
		$permission_record->roles()->sync($request->input('role_list'));
		flash()->success(
			trans('phrase.successCreate'),
			trans('phrase.objectCreated', [
				'object' => choose(code('objects.records')->name, 1),
				'name' => choose($request->record_name, 1)
			])
		);
		return redirect(session()->get('url.back', '/admin/security/permissions/' . $permission->object_code . '-' . $permission->action_code . '/records'));
	}

    public function edit(Permission $permission, PermissionRecord $permission_record)
	{
		$records = $permission->getRecords();

		$roles = Code::typeArray('roles');
		return view('admin.permissions.records.edit', compact(
			'permission',
			'permission_record',
			'records',
			'roles'
		));
	}

	public function update(Permission $permission, PermissionRecord $permission_record, PermissionRecordRequest $request)
	{
		$permission_record->update($request->all());
		$permission_record->roles()->sync($request->input('role_list'));
		flash()->success(
			trans('phrase.successUpdate'),
			trans('phrase.objectUpdated', [
				'object' => choose(code('objects.records')->name, 1),
				'name' => choose($request->record_name, 1)
			])
		);
		return redirect(session()->get('url.back', '/admin/security/permissions/' . $permission->object_code . '-' . $permission->action_code . '/records'));
	}
}
