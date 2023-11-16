<?php

namespace App\Http\Middleware;

use Closure;
use PhpParser\Node\Expr\Array_;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role1, $role2 = null, $permission = null)
    {
        if(!$request->user()->hasRole($role1, $role2)) {
            abort(403);
        }

        if($permission !== null && !$request->user()->can($permission)) {
            abort(403);
        }

        return $next($request);

    }

}
