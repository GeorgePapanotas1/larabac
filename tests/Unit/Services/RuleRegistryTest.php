<?php

namespace Tests\Unit\Services;

use Gpapanotas\Larabac\Models\Rule;
use Gpapanotas\Larabac\Repositories\MemoryRuleStorage;
use Gpapanotas\Larabac\Services\RuleRegistry;
use PHPUnit\Framework\TestCase;

class RuleRegistryTest extends TestCase
{
    protected RuleRegistry $registry;

    protected function setUp(): void
    {
        $storage = new MemoryRuleStorage();
        $this->registry = new RuleRegistry($storage);

        $rule = new Rule('rule-1', 'edit', [['attribute' => 'user.role', 'operator' => '==', 'value' => 'editor']]);
        $storage->saveRule($rule);
    }

    public function testGetRulesForAction(): void
    {
        $rules = $this->registry->getRulesForAction('edit');
        $this->assertCount(1, $rules);
        $this->assertEquals('rule-1', $rules['rule-1']->id);
    }
}