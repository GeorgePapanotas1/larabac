<?php

namespace Gpapanotas\Larabac\Repositories;

use Gpapanotas\Larabac\Models\Rule as DomainRule;
use Gpapanotas\Larabac\Repositories\Contracts\IRuleStorage;
use Laravel\Models\Rule;

class EloquentRuleStorage implements IRuleStorage
{
    public function findByAction(string $action): array
    {
        return Rule::findByAction($action)
                   ->map(fn($model) => DomainRule::fromArray($model->toArray()))
                   ->toArray();
    }

    public function saveRule(DomainRule $rule): void
    {
        Rule::updateOrCreate(
            ['id' => $rule->id],
            [
                'action' => $rule->action,
                'conditions' => $rule->conditions,
            ]
        );
    }

    public function deleteRule(string $id): void
    {
        Rule::destroy($id);
    }
}