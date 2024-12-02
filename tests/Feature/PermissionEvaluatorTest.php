<?php

namespace Tests\Feature;
use Gpapanotas\Larabac\Attributes\AttributeManager;
use Gpapanotas\Larabac\Models\Rule;
use Gpapanotas\Larabac\Repositories\MemoryRuleStorage;
use Gpapanotas\Larabac\Services\PermissionEvaluator;
use Gpapanotas\Larabac\Services\RuleRegistry;
use PHPUnit\Framework\TestCase;
use Tests\Feature\Support\TestDocument;
use Tests\Feature\Support\TestUser;
use Tests\Feature\Support\TestDocumentAttributeHandler;
use Tests\Feature\Support\TestUserAttributeHandler;

class PermissionEvaluatorTest extends TestCase
{
    protected PermissionEvaluator $evaluator;

    protected function setUp(): void
    {
        parent::setUp();

        // Setup in-memory rule storage
        $storage = new MemoryRuleStorage();

        // Seed rules into in-memory storage
        $storage->saveRule(
            new Rule(
                'edit-document',
                'edit-document',
                [
                    ['attribute' => 'user.role', 'operator' => '==', 'value' => 'editor'],
                    ['attribute' => 'document.group', 'operator' => 'in', 'value' => 'user.groups'],
                ]
            )
        );

        $storage->saveRule(
            new Rule(
                'approve-document',
                'approve-document',
                [
                    ['attribute' => 'user.role', 'operator' => '==', 'value' => 'manager'],
                    ['attribute' => 'document.status', 'operator' => '==', 'value' => 'pending'],
                ]
            )
        );


        $attributeManager = new AttributeManager();
        $attributeManager->registerHandler(TestUser::class, new TestUserAttributeHandler());
        $attributeManager->registerHandler(TestDocument::class, new TestDocumentAttributeHandler());

        // Create rule registry and evaluator
        $ruleRegistry = new RuleRegistry($storage);
        $this->evaluator = new PermissionEvaluator($attributeManager, $ruleRegistry);
    }

    public function testUserCanEditDocument(): void
    {
        $user = new TestUser('editor', ['group1', 'group2']);
        $document = new TestDocument('group1', 'draft');


        $this->assertTrue(
            $this->evaluator->hasPermission($user, 'edit-document', $document),
            'User should have permission to edit the document'
        );
    }

    public function testUserCannotEditDocumentFromDifferentGroup(): void
    {
        $user = new TestUser('editor', ['group1']);
        $document = new TestDocument('group2', 'draft');


        $this->assertFalse(
            $this->evaluator->hasPermission($user, 'edit-document', $document),
            'User should not have permission to edit a document from a different group'
        );
    }

    public function testManagerCanApprovePendingDocument(): void
    {
        $user = new TestUser('manager', []);
        $document = new TestDocument('group1', 'pending');

        $this->assertTrue(
            $this->evaluator->hasPermission($user, 'approve-document', $document),
            'Manager should have permission to approve a pending document'
        );
    }

    public function testManagerCannotApproveNonPendingDocument(): void
    {
        $user = new TestUser('manager', []);
        $document = (object) ['group' => 'group1', 'status' => 'approved'];

        $this->assertFalse(
            $this->evaluator->hasPermission($user, 'approve-document', $document),
            'Manager should not have permission to approve a non-pending document'
        );
    }

    public function testUserWithoutEditorRoleCannotEdit(): void
    {
        $user = new TestUser('viewer', ['group1']);
        $document = (object) ['group' => 'group1', 'status' => 'draft'];

        $this->assertFalse(
            $this->evaluator->hasPermission($user, 'edit-document', $document),
            'User without the editor role should not have permission to edit'
        );
    }
}
