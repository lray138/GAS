<?php namespace lray138\GAS\Math;

const subtract = __NAMESPACE__ . '\subtract';

// kind of pointless to be curried?
function subtract() {
    $subtract = function($x, $y) {
        return $x - $y;
    };
    return call_user_func_array(FP\curry2($subtract), args());
}
