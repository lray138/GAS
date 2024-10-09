<?php namespace lray138\GAS\Functional;

const flipCurryN = __NAMESPACE__ . '\flipCurryN';

/**
 * Function description.
 */
function flipCurryN($num, $callable = null) {
    $f = function($num, $callable) {
        return flipN($num, curryN($num, $callable));
    };

    return curry2($f)(...func_get_args());
}

// original, leaving it for some silly reason
/**
 * Function description.
 */
function flipCurryN_($num, $callable) {
    return flipN($num, curryN($num, $callable));
}