<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Models\Admin\PermissionRecord;

class UserCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $id)
    {
		if ($id != Auth::user()->id) {
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
