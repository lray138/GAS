<?php namespace lray138\GAS\Str;

const startsWithExpression = __NAMESPACE__ . '\startsWithExpression';

/**
 * @param string $haystack
 * @param string $needle
 * @todo this is probably Chris Pitt code
 * @return bool
 */
function startsWithExpression($haystack, $needle)
{
    $pattern = slice($needle, 1, length($needle) - 2);

    return matches($haystack, "#^{$pattern}#");
}