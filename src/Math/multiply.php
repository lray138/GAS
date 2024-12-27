<?php namespace lray138\GAS\Math;

use lray138\GAS\Functional as FP;

const multiply = __NAMESPACE__ . '\multiply';

function multiply() {
    $f = fn($x, $y) => $x * $y;
    
    return FP\curry2($f)(...func_get_args());
}

// learned this syntax from Idles
function mul(...$args) {
    return multiply(...$args);
}