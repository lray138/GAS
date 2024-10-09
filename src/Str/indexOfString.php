<?php namespace lray138\GAS\Str;

const indexOfString = __NAMESPACE__ . '\indexOfString';

/**
 * @param string $haystack
 * @param string $needle
 * @param int    $offset
 *
 * @return int
 */
function indexOfString($haystack, $needle, $offset = 0)
{
    $index = -1;

    if (($match = strpos($haystack, $needle, $offset)) !== false) {
        $index = $match;
    }

    return $index;
}