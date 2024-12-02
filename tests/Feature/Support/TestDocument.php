<?php

namespace Tests\Feature\Support;

class TestDocument
{

    public function __construct(
        public string $group,
        public string $status
    )
    {
    }

}