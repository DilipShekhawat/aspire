<?php

namespace App\Http\Middleware;

use Closure;

class checkAdmin
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
        if (auth()->user()->role == 'Admin') {
            return $next($request);
        } else {
            return response('Admin can access this endpoint', 200)
                ->header('Content-Type', 'text/plain');
        }
    }
}
