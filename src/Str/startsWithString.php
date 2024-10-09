<?php namespace lray138\GAS\Str;

const startsWithString = __NAMESPACE__ . '\startsWithString';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function startsWithString($haystack, $needle)
{
    return slice($haystack, 0, length($needle)) === $needle;
}