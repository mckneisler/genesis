<?php

namespace App\Http\Middleware;

use Closure;

class SetCustom
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
		app()->setLocale(config('custom.locale'));

		switch (config('custom.style')) {
			case 'bootstrap':
				config([
					'class.container' => 'container',
					'class.row' => 'row',
					'class.header' => config('class.header') . ' panel-heading',
					'class.panel' => 'panel panel-default',
					'class.input' => 'form-control'
				]);
				if (config('custom.labelPosition') == 'left') {
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
					'class.panel' => config('class.panel') . '',
					'class.inputDiv' => 'col-md-8',
					'class.input' => 'w3-input',
					'class.buttonDiv' => 'col-md-8 col-md-offset-4',
					'class.button' => config('class.button') . ' w3-right'
				]);
				if (config('custom.labelPosition') == 'left') {
					config([
						'class.label' => 'col-md-4 control-label',
						'class.inputDiv' => 'col-md-7',
						'class.buttonDiv' => 'col-md-7 col-md-offset-4'
					]);
				} else {
					config([
						'class.label' => 'col-md-12',
						'class.inputDiv' => 'col-md-12',
						'class.buttonDiv' => 'col-md-12'
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
				'class.search-button' => config('class.search-button') . ' w3-round-xxlarge',
				'class.header' => config('class.header') . ' w3-round-xlarge'
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

        return $next($request);
    }
}
