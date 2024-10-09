<?php namespace lray138\GAS\Functional;

const arity1 = __NAMESPACE__ . '\arity1';

/**
 * Function description.
 */
function arity1($cb) {
    $args = func_get_args();
    return arityN(1, Arr\head($args), ...Arr\tail($args));
}