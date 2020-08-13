<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;

class Admin
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
        if (Str::lower(auth()->user()->profiles) == Str::lower("Human Resource")) {
            return $next($request);
        }
        abort(404);
    }
}
