<?php namespace lray138\GAS\Str;

const trimLeft = __NAMESPACE__ . '/trimLeft';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 */
function trimLeft($needle, $haystack) {
    if (isExpression($needle)) {
        return trimLeftWithExpression($haystack, $needle);
    }
    return trimLeftWithString($haystack, $needle);
}