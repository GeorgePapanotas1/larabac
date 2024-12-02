<?php

namespace Gpapanotas\Larabac\Services;

use Gpapanotas\Larabac\Repositories\Contracts\IRuleStorage;

class RuleRegistry
{

    protected IRuleStorage $storage;

    public function __construct(IRuleStorage $storage)
    {
        $this->storage = $storage;
    }

    public function getRulesForAction(string $action): array
    {
        return $this->storage->findByAction($action);
    }
}