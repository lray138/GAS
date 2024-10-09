<?php namespace lray138\GAS\Functional;

const apply = __NAMESPACE__ . '\apply';

/**
 * Function description.
 */
function apply() {
    // add type check here
    $f = function($value, $function) {
        return $function->apply($value);
    };

    return curry2($f)(...func_get_args());
}