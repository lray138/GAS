<?php namespace lray138\GAS\Math;

const radians = __NAMESPACE__ . '\radians';

/**
 * @param int|float $number
 *
 * @return float
 */
function radians($number)
{
    return (float) \deg2rad($number);
}