<?php

namespace Gpapanotas\Larabac\Attributes\Handlers;

use Gpapanotas\Larabac\Attributes\Contracts\AttributeHandler;

class UserAttributeHandler implements AttributeHandler
{
    public function fetchAttributes($user, $resource, array $context = []): array
    {
        return [
            'user.roles' => $user->roles ?? null,
            'user.groups' => $user->groups ?? [],
        ];
    }
}