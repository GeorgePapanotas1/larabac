<?php

namespace Gpapanotas\Larabac\Attributes\Contracts;

interface AttributeHandler
{
    public function fetchAttributes($user, $resource, array $context = []): array;
}