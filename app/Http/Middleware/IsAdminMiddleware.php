<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->admin) {
            return $next($request);
        }

        return abort(403);
    }
}
