<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\PermissionRecord;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission, $id = null)
    {
//dump($permission);
		if (is_null($id)) {
			$allowed = false;
			$permissions = explode('|', $permission);
			foreach ($permissions as $permission) {
				$allowed = $allowed || Gate::allows($permission);
			}
			$denied	= !$allowed;
//dump('$id is null');
		} else {
			list($object, $action) = explode('-', $permission);
			$permission_id = PermissionRecord::lookup($object, $action, $id)->first();
			if (is_null($permission_id)) {
				$denied = Gate::denies($permission);
//dump('$id is NOT null, but $permissionId is null');
			} else {
				$denied = Gate::denies($permission, $id);
//dump('$id is NOT null, and $permissionId is NOT null');
			}
		}
//dd($denied);
		if ($denied) {
			flash()->embed(
				trans('phrase.notAuth'),
				trans('phrase.notAuthText'),
				'warning'
			);
			return redirect('/');
		}
        return $next($request);
    }
}
