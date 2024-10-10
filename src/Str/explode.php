<?php namespace lray138\GAS\Str;

use function lray138\GAS\Functional\curryN;

/**
 * Function description.
 */
const explode = __NAMESPACE__ . 'explode';

function explode() {
    return curryN(2)("explode")(...func_get_args());
}