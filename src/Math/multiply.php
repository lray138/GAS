<?php namespace lray138\GAS\Math;

const multiply = __NAMESPACE__ . '\multiply';

function multiply() {
    $multiply = function($x, $y) {
        return $x * $y;
    };
    return call_user_func_array(FP\curry2($multiply), func_get_args());
}