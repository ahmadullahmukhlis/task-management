<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsSuperAdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {

        if ((int) auth()->id() != 1) {
            abort(403);
        } else {
            return $next($request);
        }
    }
}
