<?php

return [
    // Rule storage type: 'database', 'json', or 'in_memory'
    'rule_storage' => env('PERMISSIONING_RULE_STORAGE', 'database'),

    // Database configuration
    'database' => [
        'table' => env('PERMISSIONING_RULES_TABLE', 'rules'), // Default table for rules
    ],

    'handlers' => [
        'User' => \Gpapanotas\Larabac\Attributes\Handlers\UserAttributeHandler::class,
    ],
];