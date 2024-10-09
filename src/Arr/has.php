<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const has = __NAMESPACE__ . '\has';

/**
 * @param array $array
 * @param mixed $needle
 * @return bool
 */
function has()
{
    $has = function($needle, array $array) {
        return array_key_exists($needle, $array);
    };

    return curry($has)(...func_get_args());
}