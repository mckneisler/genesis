<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use App\Models\Admin\Permission;
use App\Models\Admin\PermissionRecord;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);

		try {
			$db_available = Schema::hasTable('permissions') && Permission::count();
		} catch(\PDOException $e) {
			$db_available = false;
		}

		if ($db_available) {
			foreach ($this->getPermissions() as $permission) {
				$gate->define($permission->object_code. '-' . $permission->action_code,
					function ($user, $id = null) use ($permission) {
						if ($id) {
							$permissionRecord = PermissionRecord::lookup($permission->object_code, $permission->action_code, $id)->first();
							if ($permissionRecord) {
								return $user->hasRole($permissionRecord->roles);
							} else {
								return $user->hasRole($permission->roles);
							}
						}
						return $user->hasRole($permission->roles);
					}
				);
			}
		}
    }

	protected function getPermissions()
	{
		return Permission::select(['permissions.id'])->locale(['code'])->with('roles')->get();
	}
}
