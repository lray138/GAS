<?php namespace lray138\GAS\Str;

const toInt = __NAMESPACE__ . '\toInt';

/**
 * Converts a string to an integer.
 *
 * @param string $str The string to convert.
 * @return int The converted integer.
 */
function toInt(string $str) {
    return (int) $str;
}