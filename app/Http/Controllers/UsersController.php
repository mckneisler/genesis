<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\UserRequest;
use App\Models\Code;
use App\Models\User;
use App\Models\UserFilters;
use App\Exceptions\SystemErrorException;

class UsersController extends Controller
{
	public function __construct()
	{
        $this->middleware('maint');
		$this->middleware('auth');

		$request_segments = request()->segments();
		if (in_array('admin', $request_segments)) {
			$this->middleware('permission:users-list')->only('index');
			$this->middleware('permission:users-add')->only('create', 'store');
			$this->middleware('permission:users-edit')->only('edit', 'update');
		}

		if (in_array('profile', $request_segments)) {
			if (Route::current()) {
				$user_id = Route::current()->getParameter('users')->id;
			} else {
				$user_id = '{users}';
			}

			$this->middleware('user:' . $user_id);
		}
	}

    public function index(UserFilters $filters)
	{
		/*
		 * Default filters
		 */
		if ( ! request()->has('sort')) {
			request()->request->add(['sort' => 'name']);
			request()->request->add(['order' => 'asc']);
		}
		if ( ! request()->has('status')) {
			request()->request->add(['status' => 'active']);
		}
		session()->put('url.back', request()->fullUrl());

		$type = code('objects.users');

		$users = User::with('rolesWithLocale')
			->filter($filters)
			->get();

		$roles = Code::select('code')
			->ofType('roles')
			->locale(['name'])
			->orderBy('name')
			->lists('name', 'code')
			->toArray();

		$statuses = Code::select('code')
			->ofType('statuses')
			->locale(['name'])
			->orderBy('name')
			->lists('name', 'code')
			->toArray();
		$statuses = ['all' => trans('phrase.all')] + $statuses;
		if ( ! array_key_exists(request()->input('status'), $statuses)) {
			$message = 'Key "' . request()->input('status') . '" was not found in the list of statuses.';
			throw new SystemErrorException($message);
		}
		$status_text = $statuses[request()->input('status')];
		$statuses = array_except($statuses, request()->input('status'));

		$defaults = [];

		return view('users.index', compact(
			'type',
			'users',
			'roles',
			'statuses',
			'status_text',
			'defaults'
		));
	}

    public function create()
	{
		$type = code('objects.users');

		$roles = Code::select('id')
			->ofType('roles')
			->locale(['name'])
			->orderBy('name')
			->lists('name', 'id')
			->toArray();
		return view('users.create', compact(
			'type',
			'roles'
		));
	}

	public function store(UserRequest $request)
	{
		$type = code('objects.users');

		$values = $request->all();
		$values['password'] = bcrypt($values['password']);
		$user = User::create($values);
		if (($request->has('role_list'))) {
			$user->roles()->sync($request->input('role_list'));
		}
		flash()->success(
			trans('phrase.successCreate'),
			trans('phrase.objectCreated', [
				'object' => choose($type->name, 1),
				'name' => $user->name
			])
		);
		return redirect(session()->get('url.back', '/admin/security/users'));
	}

    public function edit(User $user)
	{
		$type = code('objects.users');

		$roles = Code::select('id')
			->ofType('roles')
			->locale(['name'])
			->orderBy('name')
			->lists('name', 'id')
			->toArray();
		return view('users.edit', compact(
			'user',
			'type',
			'roles'
		));
	}

	public function update(User $user, UserRequest $request)
	{
dump($user);
		$data_saved = false;

		$type = code('objects.users');

		if (empty($request->password)) {
			$values = array_except($request->all(), ['password']);
		} else {
			$values = $request->all();
			$values['password'] = bcrypt($values['password']);
		}
		$user->fill($values);
dump($user->getDirty());
		if ($user->isDirty()) {
			$data_saved = true;
			$user->update();
		}

		if (in_array('admin', request()->segments())) {
			if ($request->has('role_list')) {
dump($request->input('role_list'));
				$user->roles()->sync($request->input('role_list'));
			} else {
				$user->roles()->sync([]);
			}
		}
		if ($request->input('disabled')) {
			if (is_null($user->deleted_at)) {
				$data_saved = true;
				$user->delete();
				$title = 'successDisable';
				$message = 'objectDisabled';
			}
		} else {
			if ( ! is_null($user->deleted_at)) {
				$user->restore();
				$title = 'successRestore';
				$message = 'objectRestored';
			}
		}

dd($data_saved);
		if ($data_saved) {
			if ( ! isset($title) || ! isset($message)) {
				$title = 'successUpdate';
				$message = 'objectUpdated';
			}
			flash()->success(
				trans('phrase.' . $title),
				trans('phrase.' . $message, [
					'object' => choose($type->name, 1),
					'name' => $user->name
				])
			);
		} else {
			flash()->info(
				trans('phrase.nothingSaved'),
				trans('phrase.noChanges')
			);
		}

		if (in_array('admin', request()->segments())) {
			return redirect(session()->get('url.back', '/admin/security/users'));
		} else {
			return redirect('/');
		}
	}
}
