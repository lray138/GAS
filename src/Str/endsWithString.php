<?php namespace lray138\GAS\Str;

const endsWithString = __NAMESPACE__ . '\endsWithString';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function endsWithString($needle, $haystack) {
    return slice($haystack, -1 * length($needle)) === $needle;
}