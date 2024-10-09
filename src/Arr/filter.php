<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const filter = __NAMESPACE__ . '\filter';

/**
 * @param array    $array
 * @param callable $callback
 * @param mode     $mode
 * 
 * @return array
 */

function filter() {
    $args = func_get_args();

    if(count($args) === 1 && is_array($args[0])) {
        return array_filter($args[0]);
    }

    // I suppose once you get used to it... ? dunno I think this 
    $f = function($func, array $array, $mode = 0) {
        return array_filter($array, $func, $mode);
    };

    //$f = fn($func, array $array, $mode = 0) => array_filter($array, $func, $mode);

    return curry($f)(...$args);
}