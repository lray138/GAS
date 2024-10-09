<?php namespace lray138\GAS\Functional;

const flipCurry3 = __NAMESPACE__ . '\flipCurry3';

/**
 * Function description.
 */
function flipCurry3() {
    return flipCurryN(3)(...func_get_args());
}