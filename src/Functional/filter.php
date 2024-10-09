<?php namespace lray138\GAS\Functional;

const filter = __NAMESPACE__ . '\filter';

/**
 * Function description.
 */
function filter() {
    $f = function($callable, $iterable) {
        
    };

    return curry2($f)(...func_get_args());
}