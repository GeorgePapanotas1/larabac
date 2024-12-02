<?php


namespace Tests\Unit\Repositories;

use Gpapanotas\Larabac\Models\Rule;
use Gpapanotas\Larabac\Repositories\MemoryRuleStorage;
use PHPUnit\Framework\TestCase;

class InMemoryRuleStorageTest extends TestCase
{
    protected MemoryRuleStorage $storage;

    protected function setUp(): void
    {
        $this->storage = new MemoryRuleStorage();
    }

    public function testSaveAndFindByAction(): void
    {
        $rule = new Rule('rule-1', 'edit', [['attribute' => 'user.role', 'operator' => '==', 'value' => 'editor']]);
        $this->storage->saveRule($rule);

        $rules = $this->storage->findByAction('edit');
        $this->assertCount(1, $rules);
        $this->assertEquals('rule-1', $rules['rule-1']->id);
    }

    public function testDeleteRule(): void
    {
        $rule = new Rule('rule-1', 'edit', [['attribute' => 'user.role', 'operator' => '==', 'value' => 'editor']]);
        $this->storage->saveRule($rule);

        $this->storage->deleteRule('rule-1');
        $rules = $this->storage->findByAction('edit');
        $this->assertCount(0, $rules);
    }
}
