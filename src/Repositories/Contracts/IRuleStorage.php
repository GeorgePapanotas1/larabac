<?php

namespace Gpapanotas\Larabac\Repositories\Contracts;

use Gpapanotas\Larabac\Models\Rule;

interface IRuleStorage
{

    /**
     * Retrieve rules for a specific action.
     */
    public function findByAction(string $action): array;

    /**
     * Add or update a rule.
     */
    public function saveRule(Rule $rule): void;

    /**
     * Delete a rule by ID.
     */
    public function deleteRule(string $id): void;
}