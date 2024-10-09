<?php namespace lray138\GAS\Functional;

const map = __NAMESPACE__ . '\map';

/**
 * Function description.
 */
function map() {
    $f = function($callable, $iterable) {
        $out = [];
        foreach($iterable as $i) {
            $out[] = $callable($i);
        }
        return $out;
    };

    return curry2($f)(...func_get_args());
}