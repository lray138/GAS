<?php namespace lray138\GAS\Functional;

const curry3 = __NAMESPACE__ . '\curry3';

/**
 * Function description.
 */
function curry3(callable $function, $bind = false) {
    return curry_n(3, $function);
}