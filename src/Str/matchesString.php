<?php namespace lray138\GAS\Str;

const matchesString = __NAMESPACE__ . '\matchesString';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function matchesString($haystack, $needle)
{
    if ($needle === $haystack) {
        return true;
    }

    return false;
}