<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curry2 as curry;

/**
 * Function description.
 */
const explode = __NAMESPACE__ . 'explode';

function explode() {
    return call_user_func_array(curry("explode"), func_get_args());
}