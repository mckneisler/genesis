<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Schema;

use App\Models\Code;

use Closure;

class DbCheck
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
		try {
			$db_ready = Schema::hasTable('codes') && Code::count();
			$error = 'Database is not available';
		} catch (\Exception $e) {
			$db_ready = false;
			$error = $e;
		}

		if ($db_ready) {
			return $next($request);
		} else {
			return shutDown($error);
		}
    }
}
