<?php

namespace Laravel\Facades;

use Gpapanotas\Larabac\Services\PermissionEvaluator as PermissionEvaluatorService;
use Illuminate\Support\Facades\Facade;

class PermissionEvaluator extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PermissionEvaluatorService::class;
    }
}