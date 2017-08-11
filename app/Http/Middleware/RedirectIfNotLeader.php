<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfNotLeader
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
        if ($request->user()->cannot('is-leader')) {
            return redirect('/');
        }

        return $next($request);
    }
}
