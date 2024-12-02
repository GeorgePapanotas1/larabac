<?php

namespace Gpapanotas\Larabac\Evaluators;

use Gpapanotas\Larabac\Evaluators\Contracts\IRuleEvaluator;

class ContextRuleEvaluator implements IRuleEvaluator
{

    public function evaluate(array $attributes, array $condition): bool
    {
        $value = $attributes[$condition['attribute']] ?? null;

        return match ($condition['operator']) {
            '>'     => $value > $condition['value'],
            '<'     => $value < $condition['value'],
            '=='    => $value == $condition['value'],
            default => false,
        };
    }
}