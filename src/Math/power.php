<?php namespace lray138\GAS\Math;

use function lray138\GAS\Functional\curryN;

const power = __NAMESPACE__ . '\power';

/**
 * @param int|float $number
 * @param int|float $power
 *
 * @return float
 */
function power($number, $power) {
    return (float) \pow($number, $power);
}

function powerOf(...$args) {
    $f = fn($power, $number) => \pow($number, $power);

    return curryN(2, $f)(...$args);
}