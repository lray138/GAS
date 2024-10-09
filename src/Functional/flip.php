<?php namespace lray138\GAS\Functional;

const flip = __NAMESPACE__ . '\flip';

/**
 * Function description.
 */
function flip() {
    return call_user_func_array(flipN(2), func_get_args());
}