<?php

namespace Gpapanotas\Larabac\Services;

use Gpapanotas\Larabac\Attributes\AttributeManager;
use Gpapanotas\Larabac\Services\Contracts\IPermissionEvaluator;

class PermissionEvaluator implements IPermissionEvaluator
{

    public function __construct(
        protected AttributeManager $attributeManager,
        protected RuleRegistry $ruleRegistry
    )
    {
    }

    public function hasPermission($user, string $action, $resource = null, array $context = []): bool
    {
        $rules = $this->ruleRegistry->getRulesForAction($action);
        $attributes = $this->attributeManager->getAttributes($user, $resource, $context);

        foreach ($rules as $rule) {

            foreach ($rule->conditions as $condition) {
                if (!$this->evaluateCondition($attributes, $condition)) {
                    return false;
                }
            }
        }

        return true;
    }

    protected function evaluateCondition(array $attributes, array $condition): bool
    {
        $value = $attributes[$condition['attribute']] ?? null;

        // Resolve dynamic references in the condition's value
        $expectedValue = $this->resolveDynamicValue($attributes, $condition['value']);

        return match ($condition['operator']) {
            '=='     => $value == $expectedValue,
            '!='     => $value != $expectedValue,
            'in'     => is_array($expectedValue) && in_array($value, $expectedValue),
            'not_in' => is_array($expectedValue) && !in_array($value, $expectedValue),
            default  => false,
        };
    }

    protected function resolveDynamicValue(array $attributes, $value)
    {
        // If the value is a reference to another attribute, resolve it
        if (is_string($value) && isset($attributes[$value])) {
            return $attributes[$value];
        }

        return $value;
    }
}