<?php namespace lray138\GAS\Math;

const hyperbolicCosine = __NAMESPACE__ . '\hyperbolicCosine';

/**
 * @param int|float $number
 *
 * @return float
 */
function hyperbolicCosine($number)
{
    return (float) \cosh($number);
}