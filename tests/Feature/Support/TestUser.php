<?php

namespace Tests\Feature\Support;

class TestUser
{
    public function __construct(
        public string $role,
        public array $groups
    )
    {
    }
}