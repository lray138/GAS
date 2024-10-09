<?php namespace lray138\GAS\Math;

const arcCosine = __NAMESPACE__ . '\arcCosine';

/**
 * @param int|float $number
 *
 * @return float
 */
function arcCosine($number)
{
    return (float) \acos($number);
}