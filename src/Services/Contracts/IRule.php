<?php

namespace Gpapanotas\Larabac\Services\Contracts;

interface IRule
{

    public function getRulesForAction(string $action): array;
}