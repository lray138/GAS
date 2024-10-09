<?php namespace lray138\GAS\Math;

use function lray138\GAS\Functional\curry2 as curry;

const roundTo = __NAMESPACE__ . '\roundTo';

function roundTo() {
    $f = function($decimals, $number) {
        return (float) \round($number, $decimals);
    };

    return curry($f)(...func_get_args());
}

/*
function roundTo() {
    $roundTo = function($decimals, $number) {
        return (float) \round($number, $decimals);
    };

    return call_user_func_array(FP\curry2($roundTo), func_get_args());
}
*/