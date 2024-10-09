<?php namespace lray138\GAS\Str;

const join = __NAMESPACE__ . '/join';

// adding this because I tried to use concat like this,
// I thought I had a function that did this, but it looks like
function join($delimeter, $bits = null) {
    if(!is_null($bits)) {
        return implode($delimeter, array_slice(func_get_args(), 1));
    }

    return function(...$args) use ($delimeter) {
        return implode($delimeter, $args);
    };
}