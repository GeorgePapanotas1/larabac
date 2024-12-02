<?php

namespace Laravel\Middleware;

use Closure;
use Gpapanotas\Larabac\Services\PermissionEvaluator;
use Illuminate\Support\Facades\Request;

class CheckPermission
{

    public function __construct(
        protected PermissionEvaluator $evaluator)
    {
    }

    public function handle(Request $request, Closure $next, string $action)
    {
        $user = $request->user();
        $resource = $request->route()->parameter('resource'); // Customize as needed

        if (!$this->evaluator->hasPermission($user, $action, $resource)) {
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}