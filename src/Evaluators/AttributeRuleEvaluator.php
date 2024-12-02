<?php

namespace Gpapanotas\Larabac\Evaluators;

use Gpapanotas\Larabac\Evaluators\Contracts\IRuleEvaluator;

class AttributeRuleEvaluator implements IRuleEvaluator
{

    public function evaluate(array $attributes, array $condition): bool
    {
        $value = $attributes[$condition['attribute']] ?? null;

        return match ($condition['operator']) {
            '=='     => $value == $condition['value'],
            '!='     => $value != $condition['value'],
            'in'     => is_array($condition['value']) && in_array($value, $condition['value']),
            'not_in' => is_array($condition['value']) && !in_array($value, $condition['value']),
            default  => false,
        };
    }
}