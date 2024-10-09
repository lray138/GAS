<?php namespace lray138\GAS\Math;

const round = __NAMESPACE__ . '\round';


/**
 * @param int|float $number
 *
 * @return float
 */
function round($number)
{
    return (float) \round($number);
}