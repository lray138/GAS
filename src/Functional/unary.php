<?php namespace lray138\GAS\Functional;

const unary = __NAMESPACE__ . '\unary';

/**
 * Function description.
 */
// if using map and a function takes only one argumetn
// a warning will be triggered, use this
function unary() {
    // return function($x) use ($function) {
    //     return call_user_func($function, $x);
    // };
    return call_user_func_array(arity1, func_get_args());
}