<?php namespace lray138\GAS\Math;

const degrees = __NAMESPACE__ . '\degrees';

/**
 * @param int|float $number
 *
 * @return float
 */
function degrees($number)
{
    return (float) \rad2deg($number);
}