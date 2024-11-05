<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class AuthenticateBackend
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) return $next($request);

        return redirect()->route('login');
    }
}
