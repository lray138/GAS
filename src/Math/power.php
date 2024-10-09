<?php namespace lray138\GAS\Math;

const power = __NAMESPACE__ . '\power';

/**
 * @param int|float $number
 * @param int|float $power
 *
 * @return float
 */
function power($number, $power)
{
    return (float) \pow($number, $power);
}