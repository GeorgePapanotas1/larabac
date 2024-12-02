<?php

namespace Gpapanotas\Larabac\Factories;

use Gpapanotas\Larabac\Evaluators\AttributeRuleEvaluator;
use Gpapanotas\Larabac\Evaluators\ContextRuleEvaluator;
use Gpapanotas\Larabac\Evaluators\Contracts\IRuleEvaluator;

class RuleEvaluatorFactory
{
    public function make(string $type): IRuleEvaluator
    {
        return match ($type) {
            'attribute' => new AttributeRuleEvaluator(),
            'context' => new ContextRuleEvaluator(),
            default => throw new \InvalidArgumentException("Unknown evaluator type: {$type}"),
        };
    }
}