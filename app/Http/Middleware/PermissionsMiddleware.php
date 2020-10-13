<?php

namespace App\Http\Middleware;

use Closure;

class PermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $perm)
    {
        if(!auth()->check() || !auth()->user()->hasPermission($perm)){
            abort(404);
        }

        return $next($request);
    }
}
