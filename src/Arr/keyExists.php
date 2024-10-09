<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const keyExists = __NAMESPACE__ . '\keyExists';

/**
 * @note the extract should not be needed at this point.
 */
function keyExists() {
    $f = function($key, $array) {
        return array_key_exists($key, $array);
    };

    return curry($f)(...func_get_args());
}