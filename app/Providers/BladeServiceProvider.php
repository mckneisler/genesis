<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
		/**
		 * <code>
		 * {? $any_variable = "whatever" ?}
		 * </code>
		 */
		\Blade::extend(function($value) {
			return preg_replace('/\{\?(.+)\?\}/', '<?php ${1} ?>', $value);
		});
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
