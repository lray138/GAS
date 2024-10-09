<?php namespace lray138\GAS\Math;

const arcTangent = __NAMESPACE__ . '\arcTangent';

/**
 * @param int|float $number
 *
 * @return float
 */
function arcTangent($number)
{
    return (float) \atan($number);
}