<?php namespace lray138\GAS\Math;

const divide = __NAMESPACE__ . '\divide';

function divide() {
    $divide = function($x, $y) {
        return $x / $y;
    };

    return call_user_func_array(FP\curry2($divide), args());
}