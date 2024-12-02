<?php

namespace Gpapanotas\Larabac;

use Gpapanotas\Larabac\Attributes\AttributeManager;
use Gpapanotas\Larabac\Repositories\Contracts\IRuleStorage;
use Gpapanotas\Larabac\Services\PermissionEvaluator;

class PermissioningModule
{

    public function __construct(
        protected IRuleStorage $ruleStorage,
        protected AttributeManager $attributeManager,
        protected PermissionEvaluator $permissionEvaluator
    ) {
    }

    public function getEvaluator(): PermissionEvaluator
    {
        return $this->permissionEvaluator;
    }
}