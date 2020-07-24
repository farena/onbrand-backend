<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     * @throws AuthorizationException
     */
    public function handle($request, Closure $next, $role)
    {
        if (strtolower(Auth::user()->role->name) !== $role) throw new AuthorizationException();

        return $next($request);
    }
}
