<?php namespace lray138\GAS\Str;

const trimRight = __NAMESPACE__ . '/trimRight';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 */
function trimRight($needle, $haystack)
{
    if (isExpression($needle)) {
        return trimRightWithExpression($haystack, $needle);
    }

    return trimRightWithString($haystack, $needle);
}