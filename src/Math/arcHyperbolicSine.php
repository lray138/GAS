<?php namespace lray138\GAS\Math;

const arcHyperbolicSine = __NAMESPACE__ . '\arcHyperbolicSine';

/**
 * @param int|float $number
 *
 * @return float
 */
function arcHyperbolicSine($number)
{
    return (float) \asinh($number);
}