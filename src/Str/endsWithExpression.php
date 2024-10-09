<?php namespace lray138\GAS\Str;

const endsWithExpression = __NAMESPACE__ . '\endsWithExpression';

/**
 * @param string $haystack
 * @param string $needle
 *
 * @return bool
 */
function endsWithExpression($haystack, $needle) {
    $pattern = slice($needle, 1, length($needle) - 2);
    
    return matches($haystack, "#{$pattern}$#");
}