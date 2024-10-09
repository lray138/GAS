<?php namespace lray138\GAS\Math;

const subtractN = __NAMESPACE__ . '\subtractN';

// might as well use flip for this
/**
 * @note not sure what this is for really, but this does get into the concat type function with applicatives ????
 */
function subtractN() {
    $subtract = function($x, $y) {
        return $y - $x;
    };

    return call_user_func_array(FP\curry2($subtract), args());
}