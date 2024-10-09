<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const mergeLeft = __NAMESPACE__ . '\mergeLeft';

function mergeLeft(array $merge, array $with = null) {
    $f = function(array $merge, array $with) {
        return array_merge($merge, $with);
    };
    
    return curry($f)(...func_get_args());
}