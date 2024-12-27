<?php namespace lray138\GAS\Math;

use function lray138\GAS\Functional\curryN;

const limit = __NAMESPACE__ . '\limit';

/**
 * @param int|float $number
 * @param int|float $min
 * @param int|float $max
 *
 * @return int|float
 */
function limit() {
    $f = function($min, $max, $number) {
        if ($number < $min) {
            return $min;
        }

        if ($number > $max) {
            return $max;
        }

        return $number;
    };

    return curryN(3, $f)(...func_get_args());
}