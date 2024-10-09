<?php namespace lray138\GAS\Arr;

use lray138\GAS\Functional as FP;

const contains = __NAMESPACE__ . '\contains';

/**
 * @param mixed $needle
 * @param array|ArrType $haystack
 *
 * @return bool
 */
function contains() {
    $f = function($needle, $haystack): bool {
        return in_array($needle, $haystack);
    };

    return FP\curry2($f)(...func_get_args());
}