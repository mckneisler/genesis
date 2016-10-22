<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

use App\Models\Admin\Permission;
use App\Models\User;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        parent::boot($router);

		/**
		 * Model bindings for models dependent on locale can be found in the CustomConfig middleware
		 */
		$router->model('albums', 'App\Models\Music\Album');
		$router->model('artists', 'App\Models\Music\Artist');
		$router->bind('permissions', function ($value) {
			list($object, $action) = explode('-', $value);
			$permission =  Permission::select([
					'permissions.id',
					'object_id',
					'action_id',
					'permissions.created_at',
					'permissions.updated_at',
					'permissions.created_by',
					'permissions.updated_by'
				])
				->locale(['code', 'name', 'description'])
				->lookup($object, $action)
				->first();
			return $permission;
		});
		$router->model('records', 'App\Models\Admin\PermissionRecord');
		$router->model('songs', 'App\Models\Music\Song');
		$router->bind('users', function ($value) {
			return User::withTrashed()
				->where('id', $value)
				->first();
		});
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });
    }
}
