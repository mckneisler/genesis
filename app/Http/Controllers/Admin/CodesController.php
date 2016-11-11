<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Requests;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CodeRequest;
use App\Models\Code;
use App\Models\CodeLocale;
use App\Models\CodeFilters;
use App\Exceptions\SystemErrorException;

class CodesController extends Controller
{
	public function __construct()
	{
        $this->middleware('maint');
		$this->middleware('auth');

		if (Route::current()) {
			$types = Route::current()->getParameter('types');
		} else {
			$types = '{types}';
		}

		$this->middleware('permission:codes-list')->only('index');
		$this->middleware('permission:codes-add,' . $types)->only('create', 'store');
		$this->middleware('permission:codes-edit,' . $types)->only('edit', 'update');
	}

    public function index($type_path, CodeFilters $filters)
	{
		/*
		 * Default filters
		 */
		if ( ! request()->has('sort')) {
			request()->request->add(['sort' => 'code']);
			request()->request->add(['order' => 'asc']);
		}
		if ( ! request()->has('status')) {
			request()->request->add(['status' => 'active']);
		}
		session()->put('url.back', request()->fullUrl());

		list($parent, $type) = code()->getParentFromPath($type_path);
		if (is_null($type)) {
			throw (new ModelNotFoundException)->setModel(Code::class);
		}
		$codes = Code::select('id', 'code', 'deleted_at')
			->where('parent_code_id', $type->id)
			->locale(['name', 'description'])
			->withCount('children')
			->filter($filters)
			->get();
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

		return view('admin.codes.index', compact(
			'parent',
			'type',
			'codes',
			'showActions',
			'statuses',
			'status_text',
			'defaults'
		));
	}

    public function create($type_path)
	{
		list($parent, $type) = code()->getParentFromPath($type_path);
		return view('admin.codes.create', compact(
			'type'
		));
	}

	public function store(CodeRequest $request)
	{
		$type_path = Code::getPathFromId($request->parent_code_id);

		$parent = code($request->input('parent_code_id'));
		Code::create(array_add($request->all(), App::getLocale(), $request->all()));
		flash()->success(
			trans('phrase.successCreate'),
			trans('phrase.objectCreated', [
				'object' => choose($parent->name, 1),
				'name' => choose($request->name, 1)
			])
		);
		return redirect(session()->get('url.back', '/admin/' . $type_path . '/codes'));
	}

	public function edit($type_path, Code $code)
	{
		list($parent, $type) = code()->getParentFromPath($type_path);

		$values = Code::typeArrayWithDescriptions('types');

		return view('admin.codes.edit', compact(
			'type',
			'type_path',
			'values',
			'code'
		));
	}

	public function update($type_path, Code $code, CodeRequest $request)
	{
		$data_saved = false;

		$type_path = Code::getPathFromId($request->parent_code_id);
		$parent = code($request->input('parent_code_id'));

		$code->fill($request->all());
		if ($code->isDirty()) {
			$data_saved = true;
			$code->update();
		}

		$locale_id = code('locales.' . App::getLocale())->id;
		$locale = CodeLocale::where('model_id', $code->id)
			->where('locale_id', $locale_id)
			->first();
		if (is_null($locale)) {
			$locale = new CodeLocale($request->all());
			$locale->model_id = $code->id;
			$locale->locale_id = $locale_id;
			$locale->save();
		} else {
			$locale->fill($request->all());
			if ($locale->isDirty()) {
				$data_saved = true;
				$locale->update();
			}
		}
		if ($request->input('disabled')) {
			if (is_null($code->deleted_at)) {
				$code->delete();
				$data_saved = true;
				$title = 'successDisable';
				$message = 'objectDisabled';
			}
		} else {
			if ( ! is_null($code->deleted_at)) {
				$data_saved = true;
				$code->restore();
				$title = 'successRestore';
				$message = 'objectRestored';
			}
		}

		if ($data_saved) {
			if ( ! isset($title) || ! isset($message)) {
				$title = 'successUpdate';
				$message = 'objectUpdated';
			}
			flash()->success(
				trans('phrase.' . $title),
				trans('phrase.' . $message, [
					'object' => choose($parent->name, 1),
					'name' => choose($request->name, 1)
				])
			);
		} else {
			flash()->info(
				trans('phrase.nothingSaved'),
				trans('phrase.noChanges')
			);
		}

		return redirect(session()->get('url.back', '/admin/' . $type_path . '/codes'));
	}
}
