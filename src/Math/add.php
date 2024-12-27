<?php namespace lray138\GAS\Math;

use function lray138\GAS\Functional\curry2 as curry;

const add = __NAMESPACE__ . '\add';

/**
 * @param int|float
 * @param int|float
 *
 * @return float
 */
function add() {
    $f = function($x, $y) {
        return $x + $y;
    };

    return curry($f)(...func_get_args());
}