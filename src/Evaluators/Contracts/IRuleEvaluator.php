<?php

namespace Gpapanotas\Larabac\Evaluators\Contracts;

interface IRuleEvaluator
{
    public function evaluate(array $attributes, array $condition): bool;
}