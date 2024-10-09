<?php namespace lray138\GAS\Str;

const indexOf = __NAMESPACE__ . '\indexOf';

/**
 * @param string $haystack
 * @param string $needle
 * @param int    $offset
 *
 * @return int
 */
function indexOf($haystack, $needle, $offset = 0)
{
    if (isExpression($needle)) {
        return indexOfExpression($haystack, $needle, $offset);
    }

    return indexOfString($haystack, $needle, $offset);
}