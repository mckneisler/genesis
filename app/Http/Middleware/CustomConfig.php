<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

use App\Models\OptionUserValue;
use App\Models\Code;

class CustomConfig
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		/**
		 * Load system defaults
		 */
		$custom_values = OptionUserValue::forUser(1)
			->with('option', 'value')
			->get();
		foreach ($custom_values as $custom_value) {
			config(['custom.' . $custom_value->option->code => $custom_value->value->code]);
		}

		if (Auth::user()) {
			/**
			 * Override with user preferences
			 */
			$custom_values = OptionUserValue::forUser(Auth::user()->id)
				->with('option', 'value')
				->get();
			foreach ($custom_values as $custom_value) {
				config(['custom.' . $custom_value->option->code => $custom_value->value->code]);
			}
		}

		app()->setLocale(config('custom.locale'));

		switch (config('custom.style')) {
			case 'bootstrap':
				config([
					'class.container' => 'container',
					'class.row' => 'row',
					'class.header' => config('class.header') . ' panel-heading',
					'class.footer' => config('class.footer') . ' panel-heading',
					'class.panel' => 'panel panel-default',
					'class.input' => 'form-control'
				]);
				if (config('custom.label_position') == 'left') {
					config([
						'class.label' => 'col-md-4 control-label',
						'class.inputDiv' => 'col-md-6',
						'class.buttonDiv' => 'col-md-6 col-md-offset-4'
					]);
				} else {
					config([
						'class.label' => 'col-md-12',
						'class.inputDiv' => 'col-md-12',
						'class.buttonDiv' => 'col-md-12'
					]);
				}
				break;
			case 'w3':
				config([
					'class.container' => 'w3-container w3-section',
					'class.row' => 'w3-row',
					'class.header' => config('class.header') . ' w3-container',
					'class.footer' => config('class.footer') . ' w3-container',
					'class.panel' => config('class.panel') . '',
					'class.inputDiv' => 'col-md-8',
					'class.input' => 'w3-input',
					'class.button' => config('class.button') . ' w3-right'
				]);
				if (config('custom.label_position') == 'left') {
					config([
						'class.label' => 'col-md-4 control-label',
						'class.inputDiv' => 'col-md-7',
						'class.buttonDiv' => 'w3-btn-group col-md-7 col-md-offset-4'
					]);
				} else {
					config([
						'class.label' => 'col-md-12',
						'class.inputDiv' => 'col-md-12',
						'class.buttonDiv' => 'w3-btn-group col-md-12'
					]);
				}
				break;
			default:
				break;
		}

		if (config('custom.round')) {
			config([
				'class.swipe' => config('class.swipe') . ' w3-round-large',
				'class.tableDiv' => config('class.tableDiv') . ' w3-round-xlarge',
				'class.panel' => config('class.panel') . ' w3-round-xlarge',
				'class.input' => config('class.input') . ' w3-round-medium',
				'class.button' => config('class.button') . ' w3-round-xxlarge',
				'class.search' => config('class.search') . ' w3-round-xxlarge',
				'class.search_button' => config('class.search_button') . ' w3-round-xxlarge',
				'class.dropdown_button' => config('class.dropdown_button') . ' w3-round-xxlarge',
				'class.header' => config('class.header') . ' round-xlarge-top',
				'class.footer' => config('class.footer') . ' round-xlarge-bottom',
				'class.fieldset' => config('class.fieldset') . ' w3-round-xlarge'
			]);
		}

		switch (config('custom.shadow')) {
			case 'none':
				config([
					'class.tableDiv' => config('class.tableDiv') . ' w3-card',
					'class.panel' => config('class.panel') . ' w3-card'
				]);
				break;
			case 'small':
				config([
					'class.tableDiv' => config('class.tableDiv') . ' w3-card-4',
					'class.panel' => config('class.panel') . ' w3-card-4'
				]);
				break;
			case 'large':
				config([
					'class.tableDiv' => config('class.tableDiv') . ' w3-card-8',
					'class.panel' => config('class.panel') . ' w3-card-8'
				]);
				break;
			default:
				break;
		}

		/**
		 * Model bindings for models dependent on locale
		 */
		if ($request->route()->hasParameter('codes')) {
			$type_path = $request->route()->parameter('types');

			list($parent, $type) = code()->getParentFromPath($type_path);

			$code =  Code::select(
					'id',
					'code',
					'values_code_id',
					'codes.created_at',
					'codes.updated_at',
					'codes.deleted_at',
					'codes.created_by',
					'codes.updated_by',
					'codes.deleted_by'
				)
				->where('parent_code_id', $type->id)
				->where('code', $request->route()->parameter('codes'))
				->locale(['name', 'description'])
				->withTrashed()
				->first();
			$request->route()->setParameter('codes', $code);
		}

        return $next($request);
    }
}
