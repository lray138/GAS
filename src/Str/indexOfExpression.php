<?php namespace lray138\GAS\Str;

const indexOfExpression = __NAMESPACE__ . '\indexOfExpression';

/**
 * @param string $haystack
 * @param string $needle
 * @param int    $offset
 *
 * @return int
 */
function indexOfExpression($haystack, $needle, $offset = 0)
{
    $index = -1;

    if (preg_match($needle, $haystack, $matches, PREG_OFFSET_CAPTURE, $offset)) {
        $index = $matches[0][1];
    }

    return $index;
}