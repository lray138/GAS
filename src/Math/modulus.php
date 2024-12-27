<?php namespace lray138\GAS\Math;

use lray138\GAS\Functional\curryN;

const modulus = __NAMESPACE__ . '\modulus';

/**
 * @param int|float $number
 * @param int|float $divisor
 *
 * @return float
 */
function modulus($number, $divisor) {
    return (float) \fmod($number, $divisor);
}


const modulusOf = __NAMESPACE__ . '\modulusOf';
function modulusOf() {
    $f = function($diviser, $number) {
        return \fmod($number, $divisor);
    };

    return curryN(2, $f)(...func_get_args());
}