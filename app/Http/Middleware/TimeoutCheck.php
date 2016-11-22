<?php

namespace App\Http\Middleware;

use Closure;

class TimeoutCheck
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
//dump(auth()->check());
//dump(time() - session()->getMetadataBag()->getLastUsed());
		$bag = session()->getMetadataBag();
		$max = config('session.lifetime') * 60;
		if ($bag && $max < (time() - $bag->getLastUsed())) {
			flash()->embed(
				trans('phrase.notAuth'),
				trans('phrase.notAuthText'),
				'warning'
			);
			return redirect('/login');
		}

        return $next($request);
    }
}
