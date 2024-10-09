<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const unshift = __NAMESPACE__ . '\unshift';

function unshift() {
    $f = function($val, $array) {
        array_unshift($array, $val);
        return $array;
    };

    return curry($f)(...func_get_args());
}