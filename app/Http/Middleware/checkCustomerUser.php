<?php

namespace App\Http\Middleware;

use Closure;

class checkCustomerUser
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
        if (auth()->user()->role == 'User') {
            return $next($request);
        } else {
            return response('Customer can access this endpoint', 200)
                ->header('Content-Type', 'text/plain');
        }
    }
}
