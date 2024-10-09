<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2;

const exclude = __NAMESPACE__ . '\exclude';

/**
 * 
 * Note: this was from Chris Pitt Typed PHP, reversed order.
 * 
 * @param array $array
 * @param array $exclude
 * 
 * @return array
 */
function exclude() {
    $f = function($exclude, $array) {
        return array_diff($array, $exclude);
    };

    return call_user_func_array(curry2($f), func_get_args());
}