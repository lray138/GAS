<?php namespace lray138\GAS\Functional;

const hyperbolicTangent = __NAMESPACE__ . '\hyperbolicTangent';

/**
 * @param int|float $number
 *
 * @return float
 */
function hyperbolicTangent($number)
{
    return (float) \tanh($number);
}