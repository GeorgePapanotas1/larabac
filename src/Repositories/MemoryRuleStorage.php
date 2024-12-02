<?php

namespace Gpapanotas\Larabac\Repositories;

use Gpapanotas\Larabac\Models\Rule;
use Gpapanotas\Larabac\Repositories\Contracts\IRuleStorage;

class MemoryRuleStorage implements IRuleStorage
{
    protected array $rules = [];

    public function findByAction(string $action): array
    {
        return array_filter($this->rules, fn(Rule $rule) => $rule->action === $action);
    }

    public function saveRule(Rule $rule): void
    {
        $this->rules[$rule->id] = $rule;
    }

    public function deleteRule(string $id): void
    {
        unset($this->rules[$id]);
    }
}