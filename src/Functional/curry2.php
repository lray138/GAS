<?php namespace lray138\GAS\Functional;

const curry2 = __NAMESPACE__ . '\curry2';

/**
 * Function description.
 */
// haven't had a bind case yet
function curry2(callable $function, $bind = false) {
    return curry_n(2, $function);
}