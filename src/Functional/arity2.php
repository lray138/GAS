<?php namespace lray138\GAS\Functional;

const arity2 = __NAMESPACE__ . '\arity2';

/**
 * Function description.
 */
function arity2() {
    $args = func_get_args();
    return arityN(2, Arr\head($args), ...Arr\tail($args));
}