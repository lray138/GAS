<?php namespace lray138\GAS\Math;

const arcHyperbolicTangent = __NAMESPACE__ . '\arcHyperbolicTangent';

/**
 * @param int|float $number
 *
 * @return float
 */
function arcHyperbolicTangent($number)
{
    return \atanh($number);
}