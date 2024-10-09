<?php namespace lray138\GAS\Str;

const trimRightWithExpression = __NAMESPACE__ . 'trimRightWIthExpression';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return string
 */
function trimRightWithExpression($haystack, $needle)
{
    $pattern = slice($needle, 1, length($needle) - 2);

    return (string) preg_replace("#{$pattern}$#", "", $haystack);
}