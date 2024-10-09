<?php namespace lray138\GAS\Str;

const splitWithString = __NAMESPACE__ . '/splitWithString';

/**
 * @param string $haystack
 * @param string $needle
 * @param int    $limit
 *
 * @return array
 */
function splitWithString($haystack, $needle, $limit = 0)
{
    if ($limit === 0) {
        return explode($needle, $haystack);
    }

    return explode($needle, $haystack, $limit);
}