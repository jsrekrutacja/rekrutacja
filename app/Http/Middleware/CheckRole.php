<?php

namespace App\Http\Middleware;

use Closure;

class CheckRole
{
    /**
     * @param $request
     * @param Closure $next
     * @param $roles
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        $roles = explode('|', $roles);

        if (!in_array($request->user()->role, $roles)) {
            abort(403);
        }

        return $next($request);
    }
}
