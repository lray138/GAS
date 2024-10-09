<?php namespace lray138\GAS\Str;

const trimLeftWithExpression = __NAMESPACE__ . '/trimLeftWithExpression';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 */
function trimLeftWithExpression($haystack, $needle)
{
    $pattern = slice($needle, 1, length($needle) - 2);

    return (string) preg_replace("#^{$pattern}#", "", $haystack);
}