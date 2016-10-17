<?php

namespace App\Http\Controllers;

use \stdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\OptionRequest;
use App\Models\Code;
use App\Models\User;
use App\Models\OptionUserValue;
use Carbon\Carbon;

class OptionsController extends Controller
{
	public function __construct()
	{
        $this->middleware('maint');
		$this->middleware('auth');

		$request_segments = request()->segments();
		if (in_array('admin', $request_segments)) {
			$this->middleware('permission:options-edit');
		}

		if (in_array('users', $request_segments)) {
			if (Route::current()) {
				$user_id = Route::current()->getParameter('users')->id;
			} else {
				$user_id = '{users}';
			}

			$this->middleware('user:' . $user_id);
		}
	}

    public function edit(User $user)
	{
		$users = User::orderBy('name')
			->lists('name', 'id');

		$delimiters = Code::typeArrayWithDescriptions('delimiters');
		$qualifiers = Code::typeArrayWithDescriptions('qualifiers');
		$locales = Code::typeArrayWithDescriptions('locales');
		$date_formats = Code::typeArrayWithDescriptions('date_formats');
		$time_formats = Code::typeArrayWithDescriptions('time_formats');
		$timezones = Code::typeArrayWithDescriptions('timezones');
		$colors = Code::typeArrayWithDescriptions('colors');
		$fonts = Code::typeArrayWithDescriptions('fonts');
		$label_positions = Code::typeArrayWithDescriptions('label_positions');
		$yes_no = Code::typeArrayWithDescriptions('yes_no');
		$shadow_sizes = Code::typeArrayWithDescriptions('shadow_sizes');
		$styles = Code::typeArrayWithDescriptions('styles');
		$durations = Code::typeArrayWithDescriptions('durations');

		$options = Code::select(
				'codes.id',
				'code',
				'values_code_id'
			)
			->ofType('options')
			->locale(['name', 'description'])
			->withUserValues($user->id)
			->withCount('children')
			->with([
				'childrenWithLocale' => Code::closureWithUserValues($user->id),
				'childrenWithLocale.childrenWithLocale' => Code::closureWithUserValues($user->id),
			])
			->orderBy('children_count')
			->orderBy('name')
			->get();

		/**
		 * Create a dummy model for all the option values
		 */
		$model = new stdClass();
		$model->user_id = $user->id;

		$format = 'YmdHis';
		foreach ($options as $option) {
			if ($option->childrenWithLocale()->count()) {
				foreach($option->childrenWithLocale as $option_level2) {
					if ($option_level2->childrenWithLocale()->count()) {
						foreach($option_level2->childrenWithLocale as $option_level3) {
							$model->{codePath($option_level3->id) . '_value_id'} = $option_level3->value_id;
							$creates[] = $option_level3->created_at->format($format) . '|' . $option_level3->created_by;
							$updates[] = $option_level3->updated_at->format($format) . '|' . $option_level3->updated_by;
						}
					} else {
						$model->{codePath($option_level2->id) . '_value_id'} = $option_level2->value_id;
						$creates[] = $option_level2->created_at->format($format) . '|' . $option_level2->created_by;
						$updates[] = $option_level2->updated_at->format($format) . '|' . $option_level2->updated_by;
					}
				}
			} else {
				$model->{codePath($option->id) . '_value_id'} = $option->value_id;
				$creates[] = $option->created_at->format($format) . '|' . $option->created_by;
				$updates[] = $option->updated_at->format($format) . '|' . $option->updated_by;
			}
		}
		asort($creates);
		asort($updates);
		$create = explode('|', current($creates));
		$model->created_at = Carbon::createFromFormat($format, $create[0]);
		$model->created_by = $create[1];
		$update = explode('|', end($updates));
		$model->updated_at = Carbon::createFromFormat($format, $update[0]);
		$model->updated_by = $update[1];

		return view('options.edit', compact(
			'user',
			'model',
			'users',
			'options',
			'delimiters',
			'qualifiers',
			'locales',
			'date_formats',
			'time_formats',
			'timezones',
			'colors',
			'fonts',
			'label_positions',
			'yes_no',
			'shadow_sizes',
			'styles',
			'durations'
		));
	}

	public function update(User $user, OptionRequest $request)
	{
		$request_array = $request->toArray();
		foreach ($request_array as $option => $value_id) {
			if (strpos($option, '_value_id')) {
				$option = substr($option, 0, -9);
				$nodes = explode('-', $option);
				$code = end($nodes);
				$path = implode(':', array_slice($nodes, 0, count($nodes) - 1));
				$option = code($path . '.' . $code);
				$user_option = OptionUserValue::userOption($user->id, $option->id);
				if ($user->id != 1) {
					$system_option = OptionUserValue::userOption(1, $option->id);
				}
				if ($user_option) {
					$update_record = false;
					if ($user->id == 1) {
						if ($user_option->value_id != $value_id) {
							$update_record = true;
						}
					} else {
						if ($system_option->value_id == $value_id) {
							$user_option->delete();
						} else {
							$update_record = true;
						}
					}
					if ($update_record) {
						$user_option->value_id = $value_id;
						$user_option->update();
					}
				} else {
					$create_record = false;
					if ($user->id == 1) {
						$create_record = true;
					} else {
						if ($system_option->value_id != $value_id) {
							$create_record = true;
						}
					}
					if ($create_record) {
						OptionUserValue::create([
							'option_id' => $option->id,
							'user_id' => $user->id,
							'value_id' => $value_id
						]);
					}
				}
			}
		}
		flash()->success(
			trans('phrase.successUpdate'),
			trans('phrase.objectUpdated', [
				'object' => choose(code('types.options')->name, 2),
				'name' => $user->name
			])
		);
		return redirect('/');
	}
}
