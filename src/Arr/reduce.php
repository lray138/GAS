<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry3 as curry;

const reduce = __NAMESPACE__ . '\reduce';

/**
 * 
 */
function reduce(callable $callable, $initial = null, $array = []) {
    $f = function($callable, $initial, $array) {
        return array_reduce($array, $callable, $initial);
    };

    return curry($f)(...func_get_args());
}