<?php

namespace Gpapanotas\Larabac\Services\Contracts;

interface IPermissionEvaluator
{
    public function hasPermission($user, string $action, $resource = null, array $context = []): bool;
}