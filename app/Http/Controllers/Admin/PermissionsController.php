<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Code;
use App\Models\Admin\Permission;
use App\Models\Admin\PermissionFilters;
use App\Http\Requests\Admin\PermissionRequest;

class PermissionsController extends Controller
{
	public function __construct()
	{
        $this->middleware('maint');
		$this->middleware('auth');

		$this->middleware('permission:permissions-list')->only('index');
		$this->middleware('permission:permissions-add')->only('create', 'store');
		$this->middleware('permission:permissions-edit|permissions-edit_roles')->only('edit', 'update');
	}

    public function index(PermissionFilters $filters)
	{
		/*
		 * Default filters
		 */
		if ( ! request()->has('sort')) {
			request()->request->add(['sort' => 'object']);
			request()->request->add(['order' => 'asc']);
		}
		session()->put('url.back', request()->fullUrl());

		$type = code('objects.permissions');

		$permissions = Permission::select('permissions.id')
			->locale(['code', 'name'])
			->with('rolesWithLocale')
			->filter($filters)
			->get();

		$object_ids = Permission::select('object_id')
			->distinct()
			->lists('object_id')
			->all();
		$objects = Code::typeArrayWithDescriptions('objects');
		$action_ids = Permission::select('action_id')
			->distinct()
			->lists('action_id')
			->all();
		$actions = Code::typeArrayWithDescriptions('actions');
		$roles = Code::typeArrayWithDescriptions('roles');
		$defaults = [];

		return view('admin.permissions.index', compact(
			'type',
			'permissions',
			'objects',
			'actions',
			'roles',
			'defaults'
		));
	}

    public function create()
	{
		$type = code('objects.permissions');

		$objects = Code::typeArrayWithDescriptions('objects');
		$actions = Code::typeArrayWithDescriptions('actions');
		$roles = Code::typeArray('roles');
		return view('admin.permissions.create', compact(
			'type',
			'objects',
			'actions',
			'roles'
		));
	}

	public function store(PermissionRequest $request)
	{
		$type = code('objects.permissions');
		$object = code($request->input('object_id'));
		$action = code($request->input('action_id'));
		$permission = Permission::create($request->all());
		$permission->roles()->sync($request->input('role_list'));
		flash()->success(
			trans('phrase.successCreate'),
			trans('phrase.objectCreated', [
				'object' => choose($type->name, 1),
				'name' => choose($object->name, 1) . '-' . choose($action->name, 1)
			])
		);
		return redirect(session()->get('url.back', '/admin/security/permissions'));
	}

    public function edit(Permission $permission)
	{
		$type = code('objects.permissions');

		$objects = Code::typeArrayWithDescriptions('objects');
		$actions = Code::typeArrayWithDescriptions('actions');
		$roles = Code::typeArray('roles');
		return view('admin.permissions.edit', compact(
			'permission',
			'type',
			'objects',
			'actions',
			'roles'
		));
	}

	public function update(Permission $permission, PermissionRequest $request)
	{
		$type = code('objects.permissions');

		$object = code($request->input('object_id'));
		$action = code($request->input('action_id'));
		$permission->update($request->all());
		$permission->roles()->sync($request->input('role_list'));
		flash()->success(
			trans('phrase.successUpdate'),
			trans('phrase.objectUpdated', [
				'object' => choose($type->name, 1),
				'name' => choose($object->name, 1) . '-' . choose($action->name, 1)
			])
		);
		return redirect(session()->get('url.back', '/admin/security/permissions'));
	}
}
