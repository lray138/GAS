<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const filterUseBoth = __NAMESPACE__ . '\filterUseBoth';

/**
 * @param array    $array
 * @param callable $callback
 * @param mode     $mode
 * 
 * @return array
 */

function filterUseBoth($callable, array $array = null) {
    $f = function($callable, array $array): array {
        return array_filter($array, $callable, ARRAY_FILTER_USE_BOTH);
    };

    return curry($f)(...func_get_args());
}