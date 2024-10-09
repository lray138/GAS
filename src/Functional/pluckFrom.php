<?php namespace lray138\GAS\Functional;

const pluckFrom = __NAMESPACE__ . '\pluckFrom';

/**
 * Function description.
 */
function pluckFrom() {
    return flip(pluck)(...func_get_args());
}