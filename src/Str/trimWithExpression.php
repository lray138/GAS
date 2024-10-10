<?php namespace lray138\GAS\Str;

const trimWithExpression = __NAMESPACE__ . '/trimWithExpression';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 */
function trimWithExpression($needle, $haystack) {
    $pattern = slice($needle, 1, length($needle) - 2);
    return (string) preg_replace("#^{$pattern}|{$pattern}$#", "", $haystack);
}