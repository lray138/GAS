<?php namespace lray138\GAS\Functional;

const flip3 = __NAMESPACE__ . '\flip3';

/**
 * Function description.
 */
function flip3() {
    return flipN(3)(...func_get_args());
}