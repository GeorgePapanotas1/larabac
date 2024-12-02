<?php

namespace Tests\Feature\Support;

use Gpapanotas\Larabac\Attributes\Contracts\AttributeHandler;

class TestUserAttributeHandler implements AttributeHandler
{
    public function fetchAttributes($user, $resource, array $context = []): array
    {
        if (!($user instanceof TestUser)) {
            throw new \InvalidArgumentException('Invalid user type for TestUserAttributeHandler');
        }

        return [
            'user.role' => $user->role,
            'user.groups' => $user->groups,
        ];
    }
}