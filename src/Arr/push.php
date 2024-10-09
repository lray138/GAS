<?php namespace lray138\GAS\Arr;

use function lray138\GAS\Functional\curry2 as curry;

const push = __NAMESPACE__ . '\push';

function push() {
    // catch 22 here because in some cases we want the 
    // ArrType to be pushed...
    // maybe that I just started applying extract where it 
    // didn't need to be, if it was combine or something of that nature????
    // I guess this is where we go "next" level with the functional understanding

    // assuming the obove means "lift" or whatever.

    // wish I had date's on that... its Jul 15, 2024 right now.
    $push = function($value, $array) {
        array_push($array, $value);
        return $array;
    };

    return curry($push)(...func_get_args());
}