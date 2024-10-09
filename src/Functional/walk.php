<?php namespace lray138\GAS\Functional;

const walk = __NAMESPACE__ . '\walk';

/**
 * Function description.
 */
function walk() {
    $f = function($callable, $iterable) {
        foreach($iterable as $i) {
            $callable($i);
        }
    };

    return curry2($f)(...func_get_args());
}