<?php namespace lray138\GAS\Math;

const arcHyperbolicCosine = __NAMESPACE__ . '\arcHyperbolicCosine';

/**
 * @param int|float $number
 *
 * @return float
 */
function arcHyperbolicCosine($number)
{
    return (float) \acosh($number);
}