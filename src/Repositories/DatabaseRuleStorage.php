<?php

namespace Gpapanotas\Larabac\Repositories;

use Gpapanotas\Larabac\Models\Rule;
use Gpapanotas\Larabac\Repositories\Contracts\IRuleStorage;
use Illuminate\Support\Facades\DB;

class DatabaseRuleStorage implements IRuleStorage
{

    protected string $table;

    public function __construct()
    {
        $this->table = config('permissioning.database.table', 'rules');
    }

    public function findByAction(string $action): array
    {
        return DB::table($this->table)
                 ->where('action', $action)
                 ->get()
                 ->map(fn($row) => Rule::fromArray((array) $row))
                 ->toArray();
    }

    public function saveRule(Rule $rule): void
    {
        DB::table($this->table)->updateOrInsert(
            ['id' => $rule->id],
            [
                'action' => $rule->action,
                'conditions' => json_encode($rule->conditions),
            ]
        );
    }

    public function deleteRule(string $id): void
    {
        DB::table($this->table)->where('id', $id)->delete();
    }
}