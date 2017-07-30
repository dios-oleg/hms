<?php

namespace App\Http\Middleware;

use Closure;

class Blocked
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
        if ($request->user()->is_blocked) {
            \Auth::logout();
            return redirect()->route('auth.login.form');
            
        }
        
        return $next($request);
    }
}
