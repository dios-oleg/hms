<?php

namespace App\Http\Middleware;

use Closure;

class Leader
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
            return redirect('/home');
        }
        
        return $next($request);
    }
}
