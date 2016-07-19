var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function(mix) {
    mix.sass('app.scss', 'resources/assets/css');

	mix.styles([
		'libs/bootstrap.adjusted.navbar.breakpoint.css',
		'libs/jquery.smartmenus.bootstrap.css',
		'libs/w3.css',
		'libs/font-awesome.min.css',
		'libs/sweetalert.css',
		'app.css'
	], null, 'resources/assets/css');

	mix.scripts([
		'libs/jquery-1.11.3.js',
		'libs/bootstrap.min.js',
		'libs/jquery.smartmenus.min.js',
		'libs/jquery.smartmenus.bootstrap.min.js',
		'app.js'
	]);

	mix.version(['css/all.css', 'js/all.js']);
});
