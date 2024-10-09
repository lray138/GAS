<?php namespace lray138\GAS\Functional;

const arity3 = __NAMESPACE__ . '\arity3';

/**
 * Function description.
 */
function arity3() {
    $args = func_get_args();
    return arityN(2, Arr\head($args), ...Arr\tail($args));
}