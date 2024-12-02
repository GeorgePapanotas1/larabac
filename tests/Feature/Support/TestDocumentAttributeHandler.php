<?php

namespace Tests\Feature\Support;

use Gpapanotas\Larabac\Attributes\Contracts\AttributeHandler;

class TestDocumentAttributeHandler implements AttributeHandler
{
    public function fetchAttributes($user, $resource, array $context = []): array
    {
        if (!($resource instanceof TestDocument)) {
            throw new \InvalidArgumentException('Invalid resource type for TestDocumentAttributeHandler');
        }

        return [
            'document.group' => $resource->group,
            'document.status' => $resource->status,
        ];
    }
}