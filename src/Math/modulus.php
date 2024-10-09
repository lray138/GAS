<?php namespace lray138\GAS\Math;

const modulus = __NAMESPACE__ . '\modulus';

/**
 * @param int|float $number
 * @param int|float $divisor
 *
 * @return float
 */
function modulus($number, $divisor)
{
    return (float) \fmod($number, $divisor);
}