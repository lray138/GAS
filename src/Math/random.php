<?php namespace lray138\GAS\Math;

const random = __NAMESPACE__ . '\random';

/**
 * @param int|float $min
 * @param int|float $max
 *
 * @return int
 */
function random($min, $max)
{
    return (int) \mt_rand($min, $max);
}
