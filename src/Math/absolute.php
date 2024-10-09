<?php namespace lray138\GAS\Math;

const absolute = __NAMESPACE__ . '\absolute';

/**
 * @param int|float $number
 *
 * @return float
 */
function absolute($number)
{
    return (float) \abs($number);
}