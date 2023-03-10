<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;

class HasRole
{
    use ApiResponse;

    /**
     * @param Request $request
     * @param Closure $next
     * @param $roles
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!in_array($request->user()->role, $roles)) {
            return $this->errorResponse('Permission denied');
        }

        return $next($request);
    }
}
