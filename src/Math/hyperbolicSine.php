<?php namespace lray138\GAS\Math;

const hyperbolicSine = __NAMESPACE__ . '\hyperbolicSine';

/**
 * @param int|float $number
 *
 * @return float
 */
function hyperbolicSine($number)
{
    return (float) \sinh($number);
}