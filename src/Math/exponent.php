<?php namespace lray138\GAS\Math;

const exponent = __NAMESPACE__ . '\exponent';

/**
 * @param int|float $number
 *
 * @return float
 */
function exponent($number)
{
    return (float) \exp($number);
}