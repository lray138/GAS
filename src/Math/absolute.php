<?php namespace lray138\GAS\Math;

const absolute = __NAMESPACE__ . '\absolute';

/**
 * @param int|float $number
 *
 * @return int|float
 * note: not really sure what the point of this one is
 */
function absolute($number) {
    return \abs($number);
}